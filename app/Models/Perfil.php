<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Perfil extends Authenticatable
{
    use Notifiable;
	protected $table = 'perfil';
	public $timestamps = true;
	use SoftDeletes; /*borrado suave de laravel*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

	public static function rules(Request $request, $id = null)
    {

     	$rules = [
        	'nombre' => 'required|string'
    	];
        return $rules;
    }

	public function scopePerfil($query, $perfil){
		if($perfil == 2){
			return $query->where('i', '=', "3");
		}
    }

}
