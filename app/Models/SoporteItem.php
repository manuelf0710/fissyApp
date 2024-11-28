<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class SoporteItem extends Authenticatable
{
    use Notifiable;
	protected $table = 'soporte_items';
	protected $primaryKey = 'id';
	public $timestamps = true;
	use SoftDeletes; /*borrado suave de laravel*/
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','deleted_at','estado'
    ];
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soporte_id'
    ];
	
	public static function rules(Request $request, $id = null)
    {
		
     	$rules = [
        	'soporte' => 'required|number'
    	];		
        return $rules;
    }
	
   
}
