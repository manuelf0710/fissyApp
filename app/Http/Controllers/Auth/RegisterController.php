<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Invitacion;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:8', 'max:255'],
			'celular' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','required_with:confirmar_email','same:confirmar_email'],
            'confirmar_email' => ['max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
	
	public function showRegistrationFormulario(Request $request){
		 $referido = '';
		 
		 return view('auth.register')->with("referido", "referidoooo");
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		$referido_id = null;
		if($data['referido'] != ''){
			$referido = User::where("codigo", "=", $data['referido'])
							->select("id","name")
							->first();
			if($referido != '' || $referido != NULL){
				$referido_id = $referido->id;
			}
			if($data['t2'] != '' && $data['ref']){
				$modelo_invitacion = Invitacion::where("email","=", $data['email'])
												->first();
				$modelo_invitacion->estado =2;
				$modelo_invitacion->save();
			} 
			/*
			* se coloca este return en ambas partes ya que retorna antes de ejecutar y tomal el valor de referido_id @var
			*/
			return User::create([
				'name' => $data['name'],
				'celular' => $data['celular'],
				'email' => $data['email'],
				'password' => Hash::make($data['password']),
				'referido' => $referido_id
			]);			
		}else{
			return User::create([
				'name' => $data['name'],
				'celular' => $data['celular'],
				'email' => $data['email'],
				'password' => Hash::make($data['password'])
				
			]);				
			
		}
    }
	public function registerUser(Request $request){
	  /*
	  $reglas = User::rules($request);
	  
	  $validator = Validator::make($request->all() , $reglas);
	  
	  if(!($validator->fails())){
		  
		$modelo = new User();
		$modelo->name = $request->post('name');
		$modelo->celular   = $request->post('celular');
		$modelo->email     = $request->post('email');
		$modelo->password  = Hash::make($request->post('password'));
		$request->post('referido');
		if($request->post('referido') != ''){
			$referido = User::where("codigo", "=", $request->post('referido'))
							->select("id","name")
							->first();
			if($referido != '' || $referido != NULL){
				$modelo->referido = $referido->id;
			}
			if($request->post('t2') != '' && $request->post('ref')){
				$modelo_i = Invitacion::where("email","=","");
			}
			
			$modelo->save();
			Alert::success('Registro', 'Registrado correctamente');
			return redirect()->route('home');			
		}
	  }else{
		  return back()->withErrors($validator->errors());
	  }
	 */ 
	}
}
