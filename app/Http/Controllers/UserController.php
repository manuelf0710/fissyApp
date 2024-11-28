<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Perfil;
use App\Models\ListaItem;
use App\User;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Auth;
use DataTables;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 
	public function	 misDatos(){
		
		$user = User::find(auth()->user()->id);
		$tipos_identidad = ListaItem::where("lista_id", "=", 1)->get();
		
		return view('info/misdatos')->with(array('usuario' => $user,
												 'tipos_identidad' => $tipos_identidad
								  
								  ));		
		
	}	 

    public function index(Request $request)
    {
		return view('usuarios/lista');
	}
	public function getData(Request $request){
		//$usuarios = User::get();
		//return datatables()->of(\DB::table('users')->select('id','name', 'genero', 'stars', 'email', 'codigo'))
		//->make(true);	
		
		return datatables()
			->eloquent(User::query())
			->addColumn('acciones', 'usuarios.actions')
			->rawColumns(['acciones'])
			->toJson();	
	}

    public function show(Request $request)
    {
		/* call template */

    }



    public function store(Request $request)
    {
    }

  	public function editForAdmin($id)
    {
				/*
		* get model Results
		*/
		$user = User::with('perfil')->find($id);
		/*
		* call template
		*/
		$perfiles = Perfil::orderBy('id','desc')->get();
		$tipos_identidad = ListaItem::where("lista_id", "=", 1)->get();
        return view('usuarios/user-edit')->with(array(
															'usuario' => $user,
															'perfiles' => $perfiles,
															'tipos_identidad' => $tipos_identidad
												 ));
	}

 	public function edit($id)
    {
		/*
		* get model Results
		*/
		$user = User::with('perfil')->find($id);
		/*
		* call template
		*/
		$perfiles = Perfil::orderBy('id','desc')->get();
        return view('usuarios/cambiarpassword')->with(array(
															'user' => $user,
															'perfiles' => $perfiles
												 ));
    }
	
    public function updateForAdmin(Request $request, $id)
    {
		
		$reglas = [
				'name' => 'required | min:6 | max: 191',
				//'fecha_nacimiento' => 'required|date',
				'tipo_identificacion' => 'required|numeric',
				'celular' => 'required|numeric',
				'identificacion' => 'required|numeric',
				'ingreso' => 'required|numeric',
				'genero' => 'required',
				'empresa' => 'required',
				'ingreso' => 'required'
				//'email' => 'required | min:6 | max: 191',
		];

		$modelo = User::find( $id );		
		
		$inputs = request()->validate($reglas);
		
			/*
			* Verificar que se haya encontrado data, a este punto llega solo si paso validaciones
			*/
			if (! empty($modelo)) {

				/*
				* almacenar modelo cuando viene la contaseña
				*
				*/
				
				 $modelo->name = $request->post('name');

				 $modelo->celular = $request->post('celular');
				 $modelo->tipo_identificacion = $request->post('tipo_identificacion');
				 $modelo->ingreso = $request->post('ingreso');
				 $modelo->stars = $request->post('stars');
				 $modelo->empresa = $request->post('empresa') == '' ? NULL : $request->post('empresa');
				 
				 $modelo->save();
				
				/*
				* redirect to tag list View route name
				*/

					Alert::toast('Usuario Editado correctamente ', 'success')->position('top-end');
					return redirect(route("view_table_users"));

			 }else{
				 Alert::toast('Usuario', 'Se presento un error al modificar la información del usuario ','error')->position('top-end');
				 return redirect()->route('view_table_users');
			 }		
		
	}		

    public function update(Request $request, $id)
    {

		/*
		* Reglas iniciales de validación
		*/
		$reglas = [
				'name' => 'required | min:6 | max: 191',
				'fecha_nacimiento' => 'required|date',
				'tipo_identificacion' => 'required|numeric',
				'celular' => 'required|numeric',
				'identificacion' => 'required|numeric',
				'ingreso' => 'required|numeric',
				'genero' => 'required'
				//'email' => 'required | min:6 | max: 191',
		];

	    /*
		* Buscar el registro
		*/

		$modelo = User::find( $id );
//echo(json_encode($modelo));
		//exit("ingresa");
		/*
		*
		* Verificar que el campo contraseña tenga valor en los datos post
		*
		*/

		if($request->post('password') != NULL && $request->post('password') != ''){
			/*
			* Agregar las reglas de password a @var $reglas
			*/

			$reglas = array_merge( $reglas, [ 'password' => 'required| min:6| max:30 |confirmed',
											  'password_confirmation' => 'required| min:6'
			] );

			/*
			* Validar la data si no es valida redirecciona automaticamente
			*/

			$inputs = request()->validate($reglas);

			/*
			* Agregar la contraseña si pasa las reglas de validación.
			*/

			$modelo->password = Hash::make($request->post('password'));

		}else{
			/*
			* Actualizar datos sin contraseña
			*
			*/

			/*
			* Validar la data si no es valida redirecciona automaticamente
			*/

			$inputs = request()->validate($reglas);
		}
			/*
			* Verificar que se haya encontrado data, a este punto llega solo si paso validaciones
			*/
			if (! empty($modelo)) {

				/*
				* almacenar modelo cuando viene la contaseña
				*
				*/
				if ($request->hasFile('avatar')) {
					$file = $request->file('avatar');
					$modelo->avatar = $this->uploadAvatar($file);
					
				}

				 $modelo->name = $request->post('name');
				 $modelo->fecha_nacimiento = $request->post('fecha_nacimiento');
				 if($modelo->identificacion == NULL){
					$modelo->identificacion = $request->post('identificacion');
				 }
				 $modelo->celular = $request->post('celular');
				 $modelo->genero = $request->post('genero');
				 $modelo->tipo_identificacion = $request->post('tipo_identificacion');
				 $modelo->ingreso = $request->post('ingreso');
				 $modelo->deudas = $request->post('deudas') == '' ? NULL : $request->post('deudas');
				 $modelo->empresa = $request->post('empresa') == '' ? NULL : $request->post('empresa');
				 
				 $fissy_generado = false;
				 
				 if($modelo->codigo == NULL){
					$data = $this->generarCodigoFissy($modelo);
					$modelo->codigo = $data['codigo'];
					$modelo->fissy_id = $data['fissy_id'];
					$fissy_generado = true;
				 }
				 $extra_msg = $fissy_generado == true ? 'se ha creado su codigo fissy' : '';
				 $modelo->save();
				/*
				* redirect to tag list View route name
				*/
					//$user = User::find(auth()->user()->id);
					//return view('home');
					//return view('home')->with(array('usuario' => $user));
					Alert::toast('Usuario Editado correctamente '.$extra_msg, 'success')->position('top-end');
					//return redirect()->route('home');
					return redirect(route("misdatos"));
				//Alert::success('Usuario', 'Editado correctamente');
				//return redirect()->route('list_users');

			 }else{
				 Alert::toast('Usuario', 'Se presento un error al modificar la información del usuario ','error')->position('top-end');
				 //return redirect()->route('list_users');
				 return redirect()->route('misdatos');
			 }

    }
	
	public function familiaCodigo($codigo){
		$letra = 'A';
		if($codigo>9999){
			$letra = 'B';
		}
		if($codigo > 0 && $codigo < 10000){
			return $letra.'0001';
		}		
		return '';
	}	
	public function formatearCodigo($codigo){
		$letra = '';
		if($codigo>99999){
			$letra = '';
		}
		if($codigo > 0 && $codigo < 10 ){
			return $letra.'0000'.$codigo;
		}
		if($codigo >= 10 && $codigo < 100){
			return $letra.'000'.$codigo;
		}
		if($codigo >= 100 && $codigo < 1000){
			return $letra.'00'.$codigo;
		}
		if($codigo >= 1000 && $codigo < 10000){
			return $letra.'0'.$codigo;
		}
		if($codigo >= 10000 && $codigo < 99999){
			return $letra.$codigo;
		}		
		return '';
	}
	
	public function getDigitosCedula($cedula){
		$code = '';
		$array_letras = array(
								"A"=>1,
								"B"=>2,
								"C"=>3,
								"D"=>4,
								"E"=>5,
								"F"=>6,
								"G"=>7,
								"H"=>8,
								"I"=>9,
								"J"=>0
		);
		$ultimostresdigitos = substr($cedula, -3);
		$ultimostresdigitos =  str_split($ultimostresdigitos);
		foreach($ultimostresdigitos as $item){
			foreach($array_letras as $key => $val){
				if($item == $val){
					$code .= $key;
				}
			}			
		}
		return $code;
	}
	
	public function generarCodigoFissy($modelo){
		$codigofissy = null;
		$valid = true;
		/*
		* Campos obligatorios
		*/
		$campos = ['id','genero','fecha_nacimiento','email_verified_at'];
		foreach($campos as $campo){
			if($modelo->$campo == null && $valid == true){
				$valid = false;
			}
		}
		if($valid == true){
			$anio_nacimiento = explode("-",$modelo->fecha_nacimiento);
			$anio_registro   = explode("-",$modelo->created_at);
			$query	= "select TIMESTAMPDIFF(YEAR,  '".$modelo->fecha_nacimiento."' , sysdate()) edad,
							  (select max(fissy_id) from users ) fissy_id";
							  
			$diff= DB::select($query);
			
			$fissy_id = NULL;
			if($diff[0]->fissy_id == NULL){
				$fissy_id = 1;
			}
			else{
				$fissy_id = $diff[0]->fissy_id + 1;
			}
			
			$codigofissy = $this->familiaCodigo($fissy_id)
						   .$modelo->genero
						   .substr($anio_registro[0], 2,3)
						   //.substr($anio_nacimiento[0], 2,3)
						   .$diff[0]->edad
						   .$this->getDigitosCedula($modelo->identificacion)
						   //.'C'.$modelo->id
						   .$this->formatearCodigo($fissy_id);
			
		}
		$response = array(
						  "codigo" => $codigofissy,
						  "fissy_id" => $fissy_id
		);
		return $response;
	}
	public function uploadAvatar($file){
		   //Creamos una instancia de la libreria instalada   
		   $image = \Image::make($file);
		   //Ruta donde queremos guardar las imagenes
		   $path = public_path().'/avatar/';
		   // Guardar Original
		   //$image->save($path.$file->getClientOriginalName());
		   // Cambiar de tamaño
		   //$image->resize(250,null);
		   // resize the image to a width of 300 and constrain aspect ratio (auto height)
			$image->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		   // Guardar
		   $name_file = date("YmdHis");
		   //$image->widen(500)->sharpen()->save($path.$name_file.'.jpg');
		   $image->sharpen()->save($path.$name_file.'.jpg');
		   
		   //Guardamos nombre y nombreOriginal en la BD
		   //$thumbnail = new Thumbnail();
		   /*$thumbnail->name = Input::get('name');
		   $thumbnail->image = $file->getClientOriginalName();*/
		   //$thumbnail->save();
		   return $name_file.'.jpg';
	}	

	public function conectar(Request $request)
    {
        $term = $request->term ?: '';
		$usuarios = User::select('id','name','avatar','stars')
						->whereRaw("codigo is not null")
						->whereRaw("id not in (
													   select c.usuario_id as userid from contactos c 
														where c.solicita_id = '".auth()->user()->id."'
													   )")
						->where('name', 'like', '%'.$term.'%')
						->limit(7)
						->get();
			return response()->json($usuarios);		
    }

	public function exportUsers(){
		return Excel::download(new UsersExport(), 'usuarios.xlsx');
	}


	public function destroy($id)
    {
		
    }
}