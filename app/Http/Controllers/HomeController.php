<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ListaItem;
use App\Models\Invitacion;
use App\Models\Contacto;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
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
}
