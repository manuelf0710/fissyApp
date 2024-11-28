<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Gasto extends Authenticatable
{
    use Notifiable;
	protected $table = 'gastos';
	public $timestamps = true;
	use SoftDeletes; /*borrado suave de laravel*/
	protected $hidden = ['updated_at','created_at','deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'correo'
    ];
	
    protected $casts = [
        'valor' => 'integer',
    ];	

	public static function rules(Request $request, $id = null)
    {

     	$rules = [
        	'usuario_id' => 'required'
    	];
        return $rules;
    }
	
    		/*
	* Get data relationship
	*/
   public function usuario()
   {
    return $this->belongsTo('App\User', 'usuario_id', 'id');
   }

}
