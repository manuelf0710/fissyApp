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

class GastoController extends Controller
{
	
	use ComunTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function mes(){
		$meses = array(1=>'ENERO',2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 
					   10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE');
		return $meses;
	} 
	 
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
		return view('personal/gasto');		
    }
	

	public function import(Request $request){
		$file = $request->file('archivo');
		Excel::import(new GastosImport, $file);
		
		Alert::toast('Se ha cargado correctamente el excel', 'success')->position('top-end');
		return redirect(route("gastos"));		
		//return back->with('mensaje','archivo de excel importado correctamente');
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