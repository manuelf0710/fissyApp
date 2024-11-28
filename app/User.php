<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','celular','referido','referido_solicitado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at','deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public static function rules(Request $request, $id = null)
    {
		$rules =[
            'name' => ['required', 'string', 'max:255'],
			'celular' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','required_with:confirmar_email','same:confirmar_email'],
            'confirmar_email' => ['max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $rules;
    }	
	
	
	
	
    /**
     * Relación con Perfil
     *
     * return datos de perfil
     */
	 
   public function perfil()
   {
    return $this->belongsTo('App\Models\Perfil', 'perfil_id', 'id');
   } 	
}
