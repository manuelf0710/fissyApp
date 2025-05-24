@extends('layouts.app')

@section('content')
<form method="post" action="{{ route('user_admin_upd', $usuario->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="container pt-3">
	<h5 class="mt-4">Modificar información de un usuario</h5>
    <div class="row">  
		
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="required form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" aria-describedby="nombre" placeholder="Nombre" value="{{$usuario->name}}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="text" class="required form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="email" placeholder="email" value="{{$usuario->email}}" readonly>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror				
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="direccion">Celular</label>
                <input type="number" class="required form-control form-control-sm @error('celular') is-invalid @enderror" id="celular" name="celular" aria-describedby="celular" placeholder="celular" value="{{$usuario->celular}}" required>
                @error('celular')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="direccion">Fecha nacimiento <span class="fz-11 text-danger">yyyy-mm-dd</span></label>
            <input type="text" class="required form-control form-control-sm @if(empty($usuario->fecha_nacimiento)) has-calendar @endif @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" aria-describedby="fecha nacimiento" placeholder="fecha nacimiento" value="{{$usuario->fecha_nacimiento}}" readonly>
            @error('fecha_nacimiento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror            
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="direccion">Genero</label>
                <select name="genero" id="genero" class="form-control form-control-sm @error('genero') is-invalid @enderror" readonly>
                    <option value="">Seleccione...</option>
                    <option value="F" @if($usuario->genero == 'F') selected @endif>Femenino</option>
                    <option value="M" @if($usuario->genero == 'M') selected @endif>Masculino</option>
                </select>
                @error('genero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="empresa">Empresa Donde Trabaja</label>
                <input type="text" class="required form-control form-control-sm" id="empresa" name="empresa" aria-describedby="empresa" placeholder="empresa" value="{{$usuario->empresa}}" required>
            </div>
        </div>        
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="tipo_identificacion">Tipo Identificación</label>
                <select name="tipo_identificacion" id="tipo_identificacion" class="form-control form-control-sm @error('tipo_identificacion') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    @foreach($tipos_identidad as $item)
                    <option value="{{$item->id}}" @if($usuario->tipo_identificacion == $item->id) selected @endif >{{$item->nombre}}</option>
                    @endforeach
                </select>
                @error('tipo_identificacion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>                             
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="identificacion">Identificación</label>
                <input type="number" class="required form-control form-control-sm @error('identificacion') is-invalid @enderror" id="identificacion" name="identificacion" aria-describedby="identificacion" placeholder="identificacion" value="{{$usuario->identificacion}}"  @if($usuario->identificacion > 0) readonly @endif required>
                @error('identificacion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="ingreso">Ingresos Mensuales</label>
                <input type="number" class="required form-control form-control-sm @error('ingreso') is-invalid @enderror" id="ingreso" name="ingreso" aria-describedby="ingreso" placeholder="ingreso" value="@if(empty($usuario->ingreso)){{old('ingreso')}}@else{{$usuario->ingreso}}@endif" required>
                @error('ingreso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="identificacion">Valor Deudas Totales</label>
                <input type="text" class="form-control form-control-sm" id="deudas" name="deudas" aria-describedby="deudas" placeholder="deudas" value="{{$usuario->deudas}}" >
            </div>
        </div> 
        <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="stars">Calificación</label>
                <input type="number" class="form-control form-control-sm" id="stars" name="stars" aria-describedby="stars" placeholder="stars" value="{{$usuario->stars}}" >
            </div>
        </div> 

        @if(Auth::user()->perfil_id == '1')
        
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" class="form-control form-control-sm" id="password" name="password"
                            aria-describedby="password" placeholder="cambia el password" value="">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror                            
                    </div>
                </div>


                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="text" 
                            class="form-control form-control-sm @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password"
                            placeholder="cambia el password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror                           
                    </div>
                </div> 
            @endif                       
        
        <div class="col-md-12 col-sm-12 col-12">
            <button class="btn btn-fissy">Actualizar Información</button>
        </div>                            

    </div>
    </div>
</form>
@endsection