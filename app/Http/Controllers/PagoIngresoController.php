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
use App\Imports\GastosImport;
use Auth;
use Excel;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Traits\ComunTrait;

class PagoIngresoController extends Controller
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
		return view('personal/pagoingreso');		
    }
	
	public function misPagos(){
		$mispagos = DB::table('fissys')
					   ->join('lista_items', 'fissys.estado', 'lista_items.id')
		               ->where('persona_aplica', '=', auth()->user()->id)
					   //->where('lista_items.id', '=', '9')
					   ->whereNotNull('fecha_inicio')
					   ->select('fecha_inicio', 'monto', 'fissys.id', 'lista_items.nombre as estado');
					   
    return datatables()->of($mispagos)
                ->toJson();					   
	}
	
	public function misIngresos(){
				$mispagos = DB::table('fissys')
					   ->join('lista_items', 'fissys.estado', 'lista_items.id')
		               ->where('usuario_id', '=', auth()->user()->id)
					   //->where('lista_items.id', '=', '9')
					   ->whereNotNull('fecha_inicio')
					   ->select('fecha_inicio', 'monto', 'fissys.id', 'lista_items.nombre as estado');
					   
    return datatables()->of($mispagos)
                ->toJson();	
	}
	
	
    public function create()
    {
    }
	
	public function edit($id){
	}
	
	
	public function update( Request $request, $id ){

	}
	
	
    public function store(Request $request)
    {
	}
}	