<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Gasto;
use App\Models\GastoItem;
use App\Models\ListaItem;
use App\Models\FissyAplicado;
use App\Models\Invitacion;
use App\Models\Fissy;
use App\Models\Soporte;
use App\Models\SoporteItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Traits\ComunTrait;

class FinancieraController extends Controller
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
		
		$tipo_documentos = ListaItem::withoutTrashed()->where('lista_id', 5)->where('estado', 1)->get();
		
		$documentos_lista = Soporte::withoutTrashed()
						  ->where('usuario_id', auth()->user()->id )
						  ->take(6)
						  ->orderBy('anio', 'desc')
						  ->orderBy('mes', 'desc')
						  ->get();		
		
		return view('personal/situacion-financiera')->with(array(
										'tipo_documentos' => $tipo_documentos,
										'documentos_lista' => $documentos_lista
		));
    }
	
	public function getData(Request $request){
		$lista = Gasto
					::join('gasto_items', 'gastos.id', '=', 'gasto_items.gasto_id')
					->select('gasto_items.id', 'gasto_items.valor', 'gasto_items.tipo', 'gasto_items.estado', 'gasto_items.detalle')
					->where('gastos.usuario_id', '=', auth()->user()->id);
					//->orderBy("gasto_items.id", "asc");
		$lista = $lista->addSelect(DB::raw("date_format(gasto_items.fecha, '%d/%m/%Y') as fecha"));					
		$lista = $lista->addSelect(DB::raw("
											case gasto_items.tipo
											when 1
												then 'ENTRADA'
											when 2
												then 'SALIDA'
											else ''
											end tipo_des"));
											
		$lista = $lista->addSelect(DB::raw("
											case gasto_items.estado
											when 1
												then 'Pendiente'
											when 2
												then 'Pagado'
											when 3
												then 'En Mora'
											else ''
											end estado_des"));			
		//$lista = $lista->addSelect(DB::raw("ifnull(format(gasto_items.valor ,0, 'de_DE'), '0') as valor"));				
					
    return datatables()->of($lista)
				//->addColumn('acciones', 'fissyactions')
				//->rawColumns(['acciones'])
                /*->filter(function ($query) {
                    if (request()->has('name')) {
                        $query->where('users.name', 'like', "%" . request('name') . "%");
                    }
                }) */			
                ->toJson();
	}	
	
	
    public function create()
    {
		$tipos_pago = ListaItem::where("lista_id", "=", 3)->get();
		$tipos_fissy = ListaItem::where("lista_id", "=", 2)->get();
		return view('fissy')->with(array(
										'tipo_pagos' => $tipos_pago,
										'tipos_fissy' => $tipos_fissy
		));
    }
	
	public function edit($id){
		
	}
	
	
	public function update( Request $request, $id ){
			
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
			$modelo->usuario_id  = auth()->user()->id;
			$modelo->save();
			
			Alert::toast('Fissy creado correctamente', 'success')->position('top-end');
			return redirect()->route('view_table_fissy');
		}else{
			 return back()->withInput()->withErrors($validator);
		}
    }	

}