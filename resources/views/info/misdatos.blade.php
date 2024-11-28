@extends('layouts.app')

@section('content')
<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Mis datos</p>
</nav>
<form method="post" action="{{ route('user_upd', $usuario->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="container pt-3">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="form-group">
				<div class="offset-md-3 col-md-6 pb-2 bg-light">
					<label for="avatar">Foto</label>
					<div class="text-center">
						@if($usuario->avatar)
							<img src="{{asset('avatar/'.$usuario->avatar)}}" width="150" class="rounded-circle border"></img>
						@else
							<img src="{{asset('img/default-avatar.png')}}" width="150" class="rounded-circle"></img>
						
						@endif
						<div class="mt-2">
						<input type="file" class="required form-control form-control-sm bg-light" id="avatar" name="avatar" aria-describedby="avatar" placeholder="avatar" value="">
						</div>
					</div>
				</div>
					
            </div>
        </div>        
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
            <input type="text" class="required form-control form-control-sm @if(empty($usuario->fecha_nacimiento)) has-calendar @endif @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" aria-describedby="fecha nacimiento" placeholder="fecha nacimiento" value="{{$usuario->fecha_nacimiento}}" readonly  required>
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
                <select name="genero" id="genero" class="form-control form-control-sm @error('genero') is-invalid @enderror" required>
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
        
        <div class="col-md-12 col-sm-12 col-12">
            <button class="btn btn-fissy">Actualizar Información</button>
        </div>                            

    </div>
    </div>
</form>
@endsection