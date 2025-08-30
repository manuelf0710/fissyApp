<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ListaItem;
use App\Models\Invitacion;
use App\Models\Fissy;
use App\Models\FissyAplicado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Traits\ComunTrait;

class FissyController extends Controller
{
	
	use ComunTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
		$this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		/*$fissy_lista = Fissy::paginate(20);
		return view('fissy-lista')->with(array("fissys" => $fissy_lista));*/
		
		if ((auth()->user()->empresa)){
			return view('fissy-lista');
		}else{
			return redirect('/misdatos');
		}
		//
    }
	
	public function getData2(Request $request , $type){
	}
	
	public function getData(Request $request, $type ){
		/*b33 (fissys.interes/100)
		b32 fissys.periodo
		b31 fissys.monto*/		
			$arrayEstados = array(7,8);
		if($type==2){
			$arrayEstados = array(9,10,11);
		}
		
		$lista = DB::table('fissys')		
				   ->join('users', 'fissys.usuario_id', '=', 'users.id')
				   ->join('lista_items', 'fissys.estado', 'lista_items.id')
				   ->join('lista_items as monedas', 'fissys.moneda', 'monedas.id')
				   ->select("fissys.id as id",  "fissys.interes", "fissys.periodo", "fissys.monto", "fissys.estado", "fissys.tipo_pago","fissys.moneda","monedas.simbolo",
							"fissys.stars", "users.name", "lista_items.nombre as estado_des")
		->whereIn('fissys.estado',$arrayEstados);
							
		//$lista = Fissy::withoutTrashed()->with('usuario','lista');
				  //->join('lista_items', 'fissys.estado', 'lista_items.id');
				  //->select("fissys.id as id", "fissys.monto", "fissys.interes", "fissys.periodo", "fissys.estado", "fissys.tipo_pago"
							// );				
        $lista = $lista->addSelect(DB::raw(" date_format(fissys.created_at, '%Y-%m-%d') as created_at"));
		//$lista = $lista->addSelect(DB::raw(" format(fissys.monto,0, 'de_DE') monto"));							 
		$lista = $lista->addSelect(DB::raw("
											case fissys.tipo_pago
											when 4
												then 0
											when 5
												then format(round(fissys.monto * (fissys.interes/100), 0),0, 'de_DE')
											when  6
												then format(Round(fissys.monto * (( (fissys.interes/100) *  pow((fissys.interes/100) + 1, fissys.periodo)) 
												/
												(pow((fissys.interes/100) + 1, fissys.periodo) - 1)
												),0),0, 'de_DE')
											else 0
											end pago_mensual"
		));
		
		$lista = $lista->addSelect(DB::raw(
											"
											case fissys.tipo_pago
											when 4
												then format(round(fissys.monto * ( pow((fissys.interes/100) + 1, fissys.periodo) ),0),0, 'de_DE') 
											when 5
												then format(fissys.monto,0, 'de_DE')
											when  6
												then 0
											else 0
											end pago_final"								
		));		
											
        //$lista->get();
		/*return datatables()->of($lista)
                ->addColumn('testt', function() {
                    return DB::raw(" date_format(fissys.created_at, '%Y-%m-%d')");
                })
				->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw(" users.name like ?", ["%$keyword%"]);
                })				*/
				/*->editColumn('created_at', function ($request) {
					return $request->created_at->format('Y-m-d');
				})*/				
			//->toJson();
			
    return datatables()->of($lista)
				->addColumn('acciones', 'fissyactions')
				->rawColumns(['acciones'])
                ->filter(function ($query) {
                    if (request()->has('name')) {
                        $query->where('users.name', 'like', "%" . request('name') . "%");
                    }
                    if (request()->has('monto_min')) {
						if(request('monto_min') != ''){
							$query->where('fissys.monto', '>=',  request('monto_min') );
						}
                    }                    
					if (request()->has('monto_max')) {
						if(request('monto_max') != ''){
							$query->where('fissys.monto', '<=',  request('monto_max') );
						}
                    }					
					if (request()->has('tasa_min')) {
						if(request('tasa_min') != ''){
							$query->where('fissys.interes', '>=',  request('tasa_min') );
						}
                    }					
					if (request()->has('tasa_max')) {
						if(request('tasa_max') != ''){
							$query->where('fissys.interes', '<=',  request('tasa_max') );
						}
                    }					
					if (request()->has('propietario')) {
						if(request('propietario') == '1'){
							$query->where('fissys.usuario_id', '=',  auth()->user()->id );
						}
                    }
                })
                ->toJson();			
	}
	
    public function create()
    {
		$tipos_pago = ListaItem::where("lista_id", "=", 3)->get();
		$tipos_fissy = ListaItem::where("lista_id", "=", 2)->get();
		$monedas = ListaItem::where("lista_id", "=", 6)->get();
		return view('fissy')->with(array(
										'tipo_pagos' => $tipos_pago,
										'tipos_fissy' => $tipos_fissy,
										'monedas' => $monedas
		));
    }
	
	public function edit($id){

		$fissy = Fissy::
					join('users', 'fissys.usuario_id', '=', 'users.id')
					->join('lista_items', 'fissys.estado', 'lista_items.id')
					->select("users.id as id", "monto", "periodo", "interes", "tipo_pago", "fissys.estado","fissys.stars","fissys.moneda", 
					"usuario_id", "users.name", "lista_items.nombre", "lista_items.nombre",
					"fissys.id as id_fissy","fissys.fecha_inicio","fissys.dias_pago")
				    ->find($id);
		
		$tipos_pago = ListaItem::where("lista_id", "=", 3)->get();
		$estados = ListaItem::where("lista_id", "=", 4)->get();
		$monedas = ListaItem::where("lista_id", "=", 6)->get();
		
		return view('fissy-edit')->with(array(
										'fissy' => $fissy,
										'tipo_pagos' => $tipos_pago,
										'estados' => $estados,
										'monedas' => $monedas
		));
	}
	
	public function confirmarTableView(){
		$lista = FissyAplicado::
					join("fissys", "fissy_aplicados.fissy_id", "=", "fissys.id")
					->join('lista_items', 'fissys.estado', 'lista_items.id')
					->select("fissy_aplicados.id as id", "fissys.id as fissy_id", "fissys.monto", "fissys.periodo", "fissys.interes", "lista_items.nombre as estado_des")
					->where("fissys.usuario_id", "=", auth()->user()->id)
					->paginate();
		echo json_encode($lista);					
		return view('fissy-table-confirmar');
	}
	
	public function confirmarAplicar(){
		echo("en la ruta aplicar fissy");
	}
	
	public function update( Request $request, $id ){
		$reglas = [
				'monto' => 'required|numeric',
				'periodo' => 'required|numeric',
				'interes' => 'required|numeric',
				'tipo_pago' => 'required|numeric',
				'estado' => 'required|numeric',
				'stars' => 'required|numeric'
		];
		$modelo = Fissy::find( $id );
		
		$inputs = request()->validate($reglas);
		
		if (! empty($modelo)) {
			$modelo->monto     = $request->post('monto');
			$modelo->periodo   = $request->post('periodo');
			$modelo->interes   = $request->post('interes');
			$modelo->tipo_pago = $request->post('tipo_pago');
			$modelo->estado    = $request->post('estado');
			$modelo->dias_pago    = $request->post('dias_pago') == '' ? null : $request->post('dias_pago');
			$modelo->fecha_inicio    = $request->post('fecha_inicio') == '' ? null : $request->post('fecha_inicio');
			$modelo->stars = $request->post('stars');
			
			$modelo->save();
			Alert::toast('Fissy Editado correctamente ', 'success')->position('top-end');
			return redirect(route("fissy_edit",$id));			
			
		}else{
			Alert::toast('Se ha presentado un error al actualizar el fissy ', 'error')->position('top-end');
			return redirect(route("fissy_edit",$id));
			
		}			
	}
	
	function aplicar( Request $request, $id ){ /*aplicar a fissy*/
	
		$modelo = Fissy::
					join('users', 'fissys.usuario_id', 'users.id')
					->select("fissys.id", "users.email as email")
					->find( $id )
		
		;
		if (! empty($modelo)) {
			
			$modelo->persona_aplica = auth()->user()->id;
			$modelo->cobertura = 1;
			$modelo->estado = 8;
			$modelo->save();
			
			$aplica = new FissyAplicado();
			
			$aplica->persona_aplica = auth()->user()->id;
			$aplica->fissy_id = $id;
			$aplica->estado = 1;
			$aplica->save();
			
			$accion = 'Aplicar a Fissy';
			$subject = "Estas a punto de cerrar un negocio ".date('Ymd_His');
			$for = $modelo->email;
			
			
			$randomString = $this->generateRandomString(40);
			$data = array("fissy" => $modelo, "envia" => auth()->user(), "accion" => $accion, "aleatorio" => $randomString);
			
			//return view('email/aplicarfissyowner')->with(array("fissy" => $modelo, "envia" => auth()->user(), "accion" => $accion, "aleatorio" => $randomString));
			/*
			*	correo para administrador y para usuario propietario del fissy
			*
			**/

				Mail::send('email/aplicarfissyowner',$data, function($msj) use($subject,$for){
					$msj->from("info@myfissy.com","Fi\$\$y");
					$msj->subject($subject);
					//$msj->bcc('manuelf0710@gmail.com','Manuel F');
					$msj->bcc('obernaln@outlook.com','Oscar Bernal');
					$msj->to($for);
				});

			/*
			*
			* Correo para la persona que aplica al fissy
			**/
			
			/*
			return view('email/aplicarfissyapply')->with(array("fissy" => $modelo, "envia" => auth()->user(), "accion" => $accion, "aleatorio" => $randomString));	*/	
			
			    $for = auth()->user()->email;
				Mail::send('email/aplicarfissyapply',$data, function($msj) use($subject,$for){
					$msj->from("info@myfissy.com","Fi\$\$y");
					$msj->subject($subject);
					//$msj->bcc('manuelf0710@gmail.com','Manuel F');
					//$msj->bcc('obernaln@outlook.com','Oscar Bernal');
					$msj->to($for);
				});			
			
			
			
			$response = array("status" => 200,
							  "msg"    => "Se aplico al registro correctamente",
							  "fissy" => $modelo
			);			
		}
		else{
			
			$response = array("status" => 100,
							  "msg"    => "Se presento un error al aplicar al fissy"
			);				
			
		}
		
		$response = array("status" => 200,
						  "msg"    => "Se aplico al registro correctamente",
						  "fissy" => $modelo
		);
		echo(json_encode($response));
	}
	
	public function calcularPago4($fecha_inicio, $fissy){
		/*Pago de intereses y capital al final del periodo*/
		$response = array();
		$mes_hasta = DB::select("select DATE_ADD('".$fecha_inicio."',INTERVAL + ".$fissy->periodo." MONTH) fecha");
		
		$i = 1;
		$t = 1;
		$cuota = $fissy->periodo;
		$interes = ($fissy->monto * ($fissy->interes / 100));
		
		$pago_final = round(($fissy->monto * (pow(1 + ($fissy->interes / 100), $fissy->periodo))),2);
		
		while($i <= $fissy->periodo){
			$mes = DB::select("select DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH) fecha,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%Y') year_for,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%m') mes
			");
			
			$response[] = array(
								"fecha"  => $mes[0]->fecha,
								"mes" => $mes[0]->mes,
								"anio"  => $mes[0]->year_for,
								"cuota" => $cuota,
								"saldo_inicial" => $fissy->monto,
								"capital" => 0,
								"interes" => 0,
								"valor_pagado" => 0,
								"saldo_final"  => $pago_final
			                    );
			
			$i++;
			$t++;
			$cuota--;
		}
		return $response;
	}
	
	public function calcularPago5($fecha_inicio, $fissy){
		/* Pago de intereses mensuales y capital al final*/
		$response = array();
		$mes_hasta = DB::select("select DATE_ADD('".$fecha_inicio."',INTERVAL + ".$fissy->periodo." MONTH) fecha");
		
		$i = 1;
		$t = 1;
		$cuota = $fissy->periodo;
		//$interes = ($fissy->monto * ($fissy->interes / 100));
		while($i <= $fissy->periodo){
			$mes = DB::select("select 
									  (".$fissy->interes." / 100) interes,
									  DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH) fecha,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%Y') year_for,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%m') mes
			");
			
			$response[] = array(
								"fecha"  => $mes[0]->fecha,
								"mes" => $mes[0]->mes,
								"anio"  => $mes[0]->year_for,
								"cuota" => $cuota,
								"saldo_inicial" => $fissy->monto,
								"capital" => 0,
								"interes" => $fissy->interes,
								"valor_pagado" => $mes[0]->interes,
								"saldo_final"  => $fissy->fullmonto
			                    );
			
			$i++;
			$t++;
			$cuota--;
		}
		return $response;
	}

		public function calcularPago6($fecha_inicio, $fissy){
		/* Pago de intereses y capital mensualmente */
		$response = array();
		$mes_hasta = DB::select("select DATE_ADD('".$fecha_inicio."',INTERVAL + ".$fissy->periodo." MONTH) fecha");
		
		$i = 1;
		$t = 1;
		$cuota = $fissy->periodo;
		$interes = round($fissy->monto * ($fissy->interes / 100),2);
		
		$monto = $fissy->monto;
		$nuevo_monto = $fissy->monto;
		$saldo_inicial = $fissy->monto;
		$saldo_final = $fissy->monto + $interes - $fissy->pago_mensual;
		while($i <= $fissy->periodo){
			$mes = DB::select("select 
			                          DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH) fecha,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%Y') year_for,
									  date_format(DATE_ADD('".$fecha_inicio."',INTERVAL + ".$i." MONTH), '%m') mes
									  
			");
			//saldoinicial + interes - valor pagado
			$nuevo_interes = ($saldo_inicial * ($fissy->interes / 100) );
			$capital = $fissy->pago_mensual - $nuevo_interes;
			$response[] = array(
								"fecha"  => $mes[0]->fecha,
								"mes" => $mes[0]->mes,
								"anio"  => $mes[0]->year_for,
								"cuota" => $cuota,
								"saldo_inicial" => round($saldo_inicial),
								"capital" => round($capital, 0),
								"interes" => round($nuevo_interes, 0),
								"valor_pagado" => round($interes, 0),
								"saldo_final"  => round($saldo_final, 0)
			                    );
			
			$i++;
			$t++;
			$cuota--;
			
			$saldo_inicial = $saldo_final;
			$saldo_final = $saldo_inicial + ($saldo_inicial * ($fissy->interes / 100) ) - $fissy->pago_mensual;
			//$saldo_final = round($saldo_inicial + ($nuevo_interes) - $fissy->pago_mensual,0);
			$monto = $monto - $fissy->pago_mensual;
			$nuevo_monto = $monto;
			
		}
		return $response;
	}
	
	public function viewPlan($id){		
		$fissy = DB::table('fissys')
		            ->join('lista_items', 'fissys.tipo_pago', 'lista_items.id')
					->join('lista_items as monedas', 'fissys.moneda', 'monedas.id')
		            ->join('users', 'fissys.usuario_id', 'users.id')
					->leftJoin('fissy_aplicados', 'fissys.id', '=', 'fissy_aplicados.persona_aplica')
				    ->select("fissys.id as id",  "fissys.interes", "fissys.usuario_id", "fissys.fecha_inicio",
							 "fissys.periodo", "fissys.estado", "fissys.tipo_pago", "fissys.monto",
							 "lista_items.nombre as tipo_pago_des", "fissy_aplicados.persona_aplica",
							 "users.stars","monedas.simbolo","monedas.alias as aliasMoneda"
							 );
        //$fissy = $fissy->addSelect(DB::raw(" date_format(fissys.created_at, '%Y-%m-%d') as created_at"));
		$fissy = $fissy->addSelect(DB::raw(" fissys.monto as monto"));							 
		$fissy = $fissy->addSelect(DB::raw("
											case fissys.tipo_pago
											when 4
												then 0
											when 5
												then round(fissys.monto * (fissys.interes/100), 2)
											when  6
												then Round(fissys.monto * (( (fissys.interes/100) *  pow((fissys.interes/100) + 1, fissys.periodo)) 
												/
												(pow((fissys.interes/100) + 1, fissys.periodo) - 1)
												),2)
											else 0
											end pago_mensual"
		));
		
		$fissy = $fissy->addSelect(DB::raw(
											"
											case fissys.tipo_pago
											when 4
												then round(fissys.monto * ( pow((fissys.interes/100) + 1, fissys.periodo) ),0)
											when 5
												then fissys.monto
											when  6
												then 0
											else 0
											end pago_final"								
		));								 
							 
		$fissy = $fissy->addSelect(DB::raw("
											round(fissys.monto + (fissys.monto * (fissys.interes/100)),0) as fullmonto
											"								
		));	
		$fissy = $fissy->where('fissys.id', '=', $id);				
		$fissy = $fissy->addSelect(DB::raw(" date_format(fissys.created_at, '%Y-%m-%d') as created_at"))->first();	
		
		$fecha_inicio = $fissy->fecha_inicio;
		
		$plan_pago = array();
		
		$pago_final = 0;
		$pago_mensual = 0;
		
		
		if($fissy->tipo_pago == 4){
			/*Pago de intereses y capital al final del periodo*/
			$plan_pago = $this->calcularPago4($fecha_inicio, $fissy);
			//$pago_final = round(($fissy->monto * (pow(1 + ($fissy->interes / 100), $fissy->periodo))),2);
		}
		
		if($fissy->tipo_pago == 5){
			/*Pago de intereses mensuales y capital al final*/
			$plan_pago = $this->calcularPago5($fecha_inicio, $fissy);
		}
		
		if($fissy->tipo_pago == 6){
			/*Pago de intereses y capital mensualmente*/
			$plan_pago = $this->calcularPago6($fecha_inicio, $fissy);
			
			//pago_mensual = (monto * ( (interes * (Math.pow(1+interes, periodo))) / ( (Math.pow(1+interes, periodo)) -1 ) ));
			//$pago_mensual = ($fissy->monto * ( ($fissy->interes * (pow(1 + ($fissy->interes / 100), $fissy->periodo))) / ( (pow(1 + ($fissy->interes / 100), $fissy->periodo)) -1 ) ));
			
			
			$pago_final = 0;
		}		
		return view('fissy-plan')->with(array("fissy" => $fissy,
											  "fecha_inicio" => $fecha_inicio,
											  "plan_pago" => $plan_pago,
											  "pago_mensual" => $fissy->pago_mensual,
											  "pago_final" => $fissy->pago_final
		));
		
	}
	
    public function store(Request $request)
    {
		$validator = Validator::make( $request->all() , Fissy::rules($request));	
		if(!($validator -> fails())){
			$modelo = new Fissy();
			//$modelo->fissy_tipo = $request->post('fissy_tipo');
			$modelo->monto      = $request->post('monto');
			$modelo->periodo    = $request->post('periodo');
			$modelo->interes    = $request->post('interes');
			$modelo->tipo_pago  = $request->post('tipo_pago');
			$modelo->moneda     = $request->post('moneda');
			$modelo->usuario_id = auth()->user()->id;
			$modelo->save();
			
			Alert::toast('Fissy creado correctamente', 'success')->position('top-end');
			return redirect()->route('view_table_fissy');
		}else{
			 return back()->withInput()->withErrors($validator);
		}
    }	

}