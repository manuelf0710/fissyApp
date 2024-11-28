<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Soporte;
use App\Models\SoporteItem;
use App\Models\ListaItem;
use App\Models\FissyAplicado;
use App\Models\Invitacion;
use App\Models\Fissy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\ComunTrait;

class SoporteController extends Controller
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
public function index(Request $request)
    {
		echo("en metodo index soportecontroller");
		
		
		/*
		$tipo_documentos = ListaItem::withoutTrashed()->where('lista_id', 5)->get();
		return view('personal/situacion-financiera')->with(array(
										'tipo_documentos' => $tipo_documentos
		));*/
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
		//echo("en el metodo store");
		$tipo_documentos = ListaItem::withoutTrashed()->where('lista_id', 5)->where('estado', 1)->get();
		$archivos_cargados = 0;
		foreach($tipo_documentos as $doc){	
			if($request->hasFile('documento_add_'.$doc->id)){
				$archivos_cargados++;
			}
		}
		$soporte = new Soporte();
		$soporte->usuario_id = auth()->user()->id;
		$soporte->anio = date('Y');
		$fecha_documento_add = explode('-',$request->post('fecha_documento_add'));
		$soporte->mes = $request->post('fecha_documento_add') != '' ?  $fecha_documento_add[1] : date('m');	
		
		$tiene_archivos = Soporte::withoutTrashed()
						  ->where('usuario_id', $soporte->usuario_id )
						  ->where('anio', $soporte->anio )
						  ->where('mes', $soporte->mes )
						  ->get();
		$msg = !empty($tiene_archivos) ? 'El año '.$soporte->anio.' mes '.$soporte->mes.' ya tiene soportes registrados' : '';
		if(count($tipo_documentos) == $archivos_cargados && count($tiene_archivos)==0 ){

		$soporte->save();
		
		foreach($tipo_documentos as $doc){
			
			if($request->file('documento_add_'.$doc->id)){
				//dd($request->file('documento_add_'.$doc->id));
				//echo($request->file('documento_add_'.$doc->id).'</br>');
				$aleatorio = rand(1000,1000000);
				$ext = $request->file('documento_add_'.$doc->id)->extension(); 
				$random_name = $doc->alias.'_'.date("Ymd_His").'_'.$soporte->anio.'_'.$soporte->mes.'_'.$aleatorio.'.'.$ext;
				
				$soporte_item = new SoporteItem();
				$soporte_item->soporte_id = $soporte->id;
				$soporte_item->tipodocumento_id = $doc->id;
				$soporte_item->archivo = $doc->id;
				Storage::putFileAs('/public/usuarioextractos/'.$soporte->usuario_id.'/', $request->file('documento_add_'.$doc->id), $random_name);
				$soporte_item->archivo = $random_name;
				$soporte_item->save();
				
			}
		}
		Alert::toast('archivos cargados correctamente', 'success')->position('top-end');
		return redirect()->route('situacion_financiera');
		}else{
			Alert::toast('no se han cargado los archivos '.$msg, 'error')->position('top-end');
			return redirect()->route('situacion_financiera');
		}

    }	

}