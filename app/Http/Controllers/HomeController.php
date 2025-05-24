<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ListaItem;
use App\Models\Invitacion;
use App\Models\Contacto;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\ComunTrait;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	use ComunTrait;	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
		$referido = '';
		$tiene_referido = false;
		if($user->referido != null){
			$referido = User::select('name','avatar')
						->where("id","=",$user->referido)
						->first();
			$tiene_referido = true;
		}
		$recomendados = User::where("referido", "=", $user->id)->limit(5)->get();
		$contactos =    Contacto::join('users', 'contactos.solicita_id', 'users.id')
								->select('contactos.id as id','users.name', 'users.email', 'users.referido', 'users.avatar')
								->whereRaw(' (contactos.usuario_id = '.auth()->user()->id.' or contactos.solicita_id = '.auth()->user()->id.')')
								->where("estado", "=", "2")
								->distinct('pid')
								->limit(5)->get();
								
								
								
		//echo(json_encode($recomendados));
		//echo(json_encode($referido));
		//echo(json_encode($user));
		//exit;
		$tipos_identidad = ListaItem::where("lista_id", "=", 1)->get();
		$notificaciones  = DB::select("select 'contacto' tipo, count(id) total 
										from contactos 
										where usuario_id = ".auth()->user()->id." 
										  and estado =1
									  union 
									  select 'referidos' tipo, 
											 count(id) total 
									  from users 
									  where referido_solicitado = ".auth()->user()->id."  
									    and referido is null");
		
		$total_notificaciones = 0;
		
		foreach($notificaciones as $item){
			$total_notificaciones = $total_notificaciones + $item->total;
		}
        return view('home', [
            'usuario' => $user,
            'tipos_identidad' => $tipos_identidad,
            'tiene_referido' => $referido,
            'referido' => $referido,
            'recomendados' => $recomendados,
            'contactos' => $contactos,
            'notificaciones' => $notificaciones,
            'total_notificaciones' => $total_notificaciones
        ]);
    }


	public function checkContacto(){
		
	}
	
    public function aprobarContacto(Request $request)
    {
		$codigo_contacto = $request->post('data_contacto');
		$accion          = $request->post('data_action');
		$msg = 'Se ha presentado un error al guardar la información';
		$type = 'error';
		if(!empty($codigo_contacto) && !empty($accion)){
			$modelo = Contacto::with('usuario_solicita')->find($codigo_contacto);
			$aprueba = User::find(auth()->user()->id);
			if(!empty($modelo)){
				$modelo->estado = $accion;
				$modelo->save();
				
				$type = "success";
				$msg  = $accion == '2' ? ' Se aprobo contacto ' : 'No se aprobo contacto';
				
				$randomString = $this->generateRandomString(40);	
				$data = array("aprueba" => $aprueba, "accion" => $accion, "aleatorio" => $randomString);
				//return view('email/accioncontacto')->with(array("envia" => $aprueba, "accion" => $accion, "aleatorio" => $randomString));
				$subject = "Respuesta a solicitud de contacto ".date('Ymd_His');
				$for = $modelo->usuario_solicita->email;
				Mail::send('email/accioncontacto',$data, function($msj) use($subject,$for){
					$msj->from("info@myfissy.com","Fi\$\$y");
					$msj->subject($subject);
					//$msj->bcc('manuelf0710@gmail.com','Manuel F');
					$msj->bcc('obernaln@outlook.com','Oscar Bernal');
					$msj->to($for);
				});					
			}
		}
			Alert::toast('Acción registrada!! '.$msg, $type)->position('top-end');;
			return redirect()->route('aprobar_contacto_lista');		
	}
	
    public function aprobarContactoLista(Request $request)
    {
		$lista = Contacto::join('users', 'contactos.solicita_id', 'users.id')
						 ->select('contactos.id as id','users.name', 'users.email', 'users.referido')
						 ->where("usuario_id", "=", auth()->user()->id)
						 ->where("estado", "=","1")
						 ->paginate(15);
						 //echo json_encode($lista);
		return view('template/contacto_aprobado_lista')->with(array("lista" => $lista, "type" => "web"));
	}		
	
    public function contactofissy(Request $request)
    {
		$emails_to = array();
		foreach($request->post('conectar') as $cont){
			$usuario = User::where("id", "=", $cont)->first();
			if(!empty($usuario)){
				array_push($emails_to, $usuario->email);
			}			
		}
		//array_push($emails_to, 'obernaln@outlook.com');
		//print_r($emails_to);
		$envia = User::find(auth()->user()->id);
		$randomString = $this->generateRandomString(40);	
		$data = array("envia" => $envia, "aleatorio" => $randomString);
		//return view('email/contactofissy')->with(array("envia" => $envia, "aleatorio" => $randomString));
		
			//exit;		
		$send_mail = false;	
		foreach($request->post('conectar') as $cont){
			
		    $existe = Contacto::where("usuario_id", "=", $cont)
					          ->where("solicita_id", "=", auth()->user()->id)
					          ->first();
			if($existe == null){
				if($send_mail == false){
					$send_mail = true;
				}
				$usuario = User::where("id", "=", $cont)->first();
				if(!empty($usuario)){
					array_push($emails_to, $usuario->email);
				}				
				$modelo = new Contacto();
				$modelo->usuario_id = $cont;
				$modelo->solicita_id = auth()->user()->id;
				$modelo->save();
			}
		}
		
		if( $send_mail == true ){
			$subject = "Solicitud de contacto ".date('Ymd_His');
			$for = $emails_to;
			Mail::send('email/contactofissy',$data, function($msj) use($subject,$for){
				$msj->from("info@myfissy.com","Fi\$\$y");
				$msj->subject($subject);
				//$msj->bcc('manuelf0710@gmail.com','Manuel F');
				$msj->bcc('obernaln@outlook.com','Oscar Bernal');
				$msj->to($for);
			});			
		}
		
		Alert::toast('Tu invitación ha sido enviada, pronto tu red aumentará de tamaño!! ', 'success')->position('top-end');;
		return redirect()->route('home');		
	}

	public function referidofissy(Request $request)
    {
		if(empty($request->post('pedir_referido'))){
			Alert::toast('Se ha presentado un error, se necesita un código de referido!! ', 'error')->position('top-end');;
			return redirect()->route('home');
		}else{
			$referido = User::where("codigo", "=", $request->post('pedir_referido'))
					->select('id','email','name')
					->first();
					if(!empty($referido)){
						$modelo = User::find(auth()->user()->id);
						$modelo->referido_solicitado = $referido->id;
						$this->mailReferido($modelo, $referido);
						//$randomString = $this->generateRandomString(40);
						//return view('email/referidofissy')->with(array("envia" => $modelo, "recibe" => $referido, "aleatorio" => $randomString));
						$modelo->save();
						Alert::toast('El código de referido ha sido solicitado.!! ', 'success')->position('top-end');;
						return redirect()->route('home');
					}else{
						Alert::toast('El código de referido ingresado no corresponde con ninguno de nuestros registros!! ', 'error')->position('top-end');;
						return redirect()->route('home');
					}
		}
	}
	
	public function mailReferido($envia, $recibe){
		/*
		* @params $enviar quien debe autorizar y a quien se le envia el mail
		* $recibe quien solicita el codigo de referido debe esperar que su solicitud sea aprobada.
		*/
			$randomString = $this->generateRandomString(40);
			$data = array("envia" => $envia, "recibe" => $recibe, "aleatorio" => $randomString);
			//return view('email/referidofissy')->with(array("envia" => $envia, "recibe" => $recibe, "aleatorio" => $randomString));	

			$subject = "Solicitud de referencia en Fi\$\$y ".date('d/m/Y His');
			$for = $recibe->email;
			Mail::send('email/referidofissy',$data, function($msj) use($subject,$for){
				$msj->from("info@myfissy.com","Fi\$\$y");
				$msj->subject($subject);
				$msj->to($for);
			});		
		
	}

	public function aprobarReferido(Request $request){
		$codigo_contacto = $request->post('data_contacto');
		$accion          = $request->post('data_action');
		$msg = 'Se ha presentado un error al guardar la información';
		$type = 'error';
		if(!empty($codigo_contacto) && !empty($accion)){
			$modelo = User::find($codigo_contacto);
			$aprueba = User::find(auth()->user()->id);
			if(!empty($modelo)){
				
				$modelo->referido = $accion == '2' ? auth()->user()->id : NULL;
				$modelo->referido_solicitado = $accion== '2' ? auth()->user()->id : NULL;
				$modelo->save();
				
				$type = "success";
				$msg  = $accion == '2' ? ' Se aprobo referido ' : 'No se aprobo referido';
				
				$randomString = $this->generateRandomString(40);	
				$data = array("aprueba" => $aprueba, "accion" => $accion, "aleatorio" => $randomString);
				//return view('email/accionreferido')->with(array("envia" => $aprueba, "accion" => $accion, "aleatorio" => $randomString));
				$subject = "Respuesta a referencia ".date('Ymd_His');
				$for = $modelo->email;
				Mail::send('email/accionreferido',$data, function($msj) use($subject,$for){
					$msj->from("info@myfissy.com","Fi\$\$y");
					$msj->subject($subject);
					//$msj->bcc('manuelf0710@gmail.com','Manuel F');
					$msj->bcc('obernaln@outlook.com','Oscar Bernal');
					$msj->to($for);
				});
			}
		}
			Alert::toast('Acción registrada!! '.$msg, $type)->position('top-end');;
			return redirect()->route('aprobar_referido_lista');			
	}
	
	public function aprobarReferidoLista(Request $request){
		if(!empty($request->get('type'))){
			if(!empty($request->get('u')) && !empty($request->get('d')) && $request->get('d') == auth()->user()->id ){ /*mail origin*/
				$aprueba = User::where("id", "=", $request->get('d'))
							->select('id','email','name')
							->first();
				$solicita = User::select('id','name', 'email', 'referido')
							->whereNotNull('referido_solicitado')
							->whereNull('referido')
							->find($request->get('u'));
				if(!empty($solicita)){
					$solicita->referido = $aprueba->id;
					//$solicita->referido_solicitado = null;
					$solicita->save();
					$status = $solicita->referido ? '1' : '2';
					return view('template/referido_aprobado_lista')->with(array("lista" => $solicita, "solicita" => $solicita, "type" => "email", "status" => $status));	
				}else{
					return view('template/referido_aprobado_lista')->with(array("lista" => $solicita, "solicita" => $solicita, "type" => "expired"));
				}
			}else{
				return view('template/referido_aprobado_lista')->with(array("type" => "expired"));
			}
		}else{
		
		$aprobar_lista = User::select('id','name', 'email', 'referido')
							->where('referido_solicitado', '=', auth()->user()->id)
							->whereNull('referido')
							->paginate(20);
		return view('template/referido_aprobado_lista')->with(array("lista" => $aprobar_lista, "type" => "web"));
		}		
	}
	
	public function invitarfissy(Request $request)
    {
		
		//echo($request->post('email_invitado'));
		/*
		*
		* Verificar que el correo invitado no este registrado en fissy
		*/
		$verificar_invitado = User::where("email", "=", $request->post('email_invitado'))
						    ->select('id','email')
							->first();
			/*
			$numeros = range(0, 9);
			$letras_min = range('a','z');
			//$letras_may = range('A','Z');
			$data_array = join("",array_merge($numeros, $letras_min));
			
			$randomString = '';
			$charactersLength = strlen($data_array);
			for ($i = 0; $i < 40; $i++) {
				$randomString .= $data_array[rand(0, $charactersLength - 1)];
			}*/
			$randomString = $this->generateRandomString(40);
			
			
		/*return view('email/invitarfissy')->with(array("info" => $modelo, "aleatorio" => $randomString));			
		exit;*/
		if($verificar_invitado == '' && $verificar_invitado == NULL){
			$verificar_invitado_table = Invitacion::where("email", "=", $request->post('email_invitado'))
					->select('id','email')
					->first();
			$msg = '';
			if($verificar_invitado_table != '' && $verificar_invitado_table != NULL){
				$msg = "el usuario ya ha sido invitado se vuelve a enviar mail";
				$modelo = $verificar_invitado_table;
			}else{
				$modelo = new Invitacion();
				
				$modelo->email = $request->post('email_invitado');
				$modelo->persona = auth()->user()->id;
				$modelo->save();
			}
			
			$data = array("info" => $modelo, "aleatorio" => $randomString);
			$subject = "Invitación a registrarse en Fi\$\$y ".date('d/m/Y His');
			$for = $request->post('email_invitado');
			Mail::send('email/invitarfissy',$data, function($msj) use($subject,$for){
				$msj->from("info@myfissy.com","Fi\$\$y");
				$msj->subject($subject);
				$msj->to($for);
			});	
			Alert::toast('Tu invitación ha sido enviada, pronto tu red aumentará de tamaño!! '.$msg, 'success')->position('top-end');;
			return redirect()->route('home');				
		}else{
			Alert::toast('El usuario invitado ya se encuentra registrado como usuario de fissy', 'info')->position('top-end');;
			return redirect()->route('home');
		}
	
	}	
}
