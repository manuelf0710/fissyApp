<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Fissy extends Authenticatable
{
    use Notifiable;
	protected $table = 'fissys';
	protected $primaryKey = 'id';
	public $timestamps = true;
	use SoftDeletes; /*borrado suave de laravel*/
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at','deleted_at'
    ];	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto',
        'periodo',
        'interes',
        'tipo_pago',
		    'cobertura',
        'stars'
    ];
	
    protected $casts = [
        'created_at' => 'date',
    ];	
	
	public static function rules(Request $request, $id = null)
    {
		
     	$rules = [
        	'monto' => 'required|string',
        	'periodo' => 'required|numeric',
        	'interes' => 'required|string',
        	'tipo_pago' => 'required|string'
    	];		
        return $rules;
    }
	
  public function usuario()
  {
	return $this->hasOne('App\User',  'id', 'usuario_id');
  } 

   public function lista()
  {
	return $this->hasOne('App\Models\ListaItem',  'id', 'tipo_pago');
  }
  
	public function scopePropietario($query, $usuario, $propietario){
		if($propietario == 1)
			return $query->where('fissys.usuario_id', '=', "$usuario");
    }   
	
   
}
