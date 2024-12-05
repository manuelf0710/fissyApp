<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password','celular','referido','referido_solicitado'
    ];    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
