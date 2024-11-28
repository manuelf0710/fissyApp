<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class FissyAplicado extends Authenticatable
{
    use Notifiable;
	protected $table = 'fissy_aplicados';
	protected $primaryKey = 'id';
	public $timestamps = true;
	use SoftDeletes; /*borrado suave de laravel*/
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       
    ];
	
	public static function rules(Request $request, $id = null)
    {
		
     	$rules = [
        	'persona_aplica' => 'required|string'
    	];		
        return $rules;
    }
	
   
}
