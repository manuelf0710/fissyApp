@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{route('fissy_upd', $fissy->id_fissy)}}" method="post" name="form_fissy" id="form_fissy">
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Crea una oportunidad</p>
    </nav>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                @csrf
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="moneda">Moneda</label>
                        <select name="moneda" id="moneda" class="required form-control form-control-sm @error('moneda') is-invalid @enderror" aria-describedby="moneda" placeholder="tipo moneda" required>
                            <option value="">Seleccione...</option>
                            @foreach($monedas as $item)
                            <option value="{{$item->id}}" @if($item->id == $fissy->moneda) selected @endif>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        @error('moneda')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span class="text-muted fz-11">No colocar puntos o comas para esta cifra</span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="text" onchange="showInfoCards()" class="required form-control form-control-sm @error('monto') is-invalid @enderror" id="monto" name="monto" aria-describedby="monto" placeholder="monto" value="{{ $fissy->monto }}" required>
                        @error('monto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span class="text-muted fz-11">No colocar puntos o comas para esta cifra</span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="periodo">Periodo (en meses)</label>
                        <input type="number" onchange="showInfoCards()" class="required form-control form-control-sm @error('periodo') is-invalid @enderror" id="periodo" name="periodo" aria-describedby="periodo" placeholder="periodo" value="{{ $fissy->periodo }}" required>
                        @error('periodo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span class="text-muted fz-11">No colocar puntos o comas para esta cifra</span>
                    </div>
                </div>                
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="inateres">Tasa de interés mensual (%)</label>
                        <input step="0.001" min="0" type="number" onchange="showInfoCards()" class="required form-control form-control-sm @error('interes') is-invalid @enderror" id="interes" name="interes" aria-describedby="interes" placeholder="interes" value="{{ $fissy->interes }}" required>
                        @error('interes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span class="text-muted fz-11">*Utilizar punto para los decimales</span>
                    </div>
                </div> 
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="fissy_tipo">Tipo de Pago</label>
                        <select name="tipo_pago" id="tipo_pago" class="required form-control form-control-sm @error('tipo_pago') is-invalid @enderror" aria-describedby="tipo_pago" placeholder="tipo pago" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipo_pagos as $item)
                            <option value="{{$item->id}}" @if($item->id == $fissy->tipo_pago) selected @endif>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        @error('tipo_pago')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="fissy_tipo">Estado</label>
                        <select name="estado" id="estado" class="required form-control form-control-sm @error('estado') is-invalid @enderror" aria-describedby="estado" placeholder="tipo estado" required>
                            <option value="">Seleccione...</option>
                            @foreach($estados as $item)
                            <option value="{{$item->id}}" @if($item->id == $fissy->estado) selected @endif>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>                
                <div class="col-md-6 col-sm-12 col-12">
                   
                    <div class="form-group">
                        <label for="usuario">Usuario propietario fissy: </label> 
                        <br>
                        <p class="text-muted">{{ $fissy->name }}</p>
                    </div>                    
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                   
                    <div class="form-group">
                        <label for="usuario">Calificacion: </label> 
                        
                        <input type="number" class="form-control form-control-sm" id="stars" name="stars" aria-describedby="stars" placeholder="stars" value="{{$fissy->stars}}" >                        
                    </div>                    
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="fissy_tipo">Fecha Inicio</label>
                        <input name="fecha_inicio" id="fecha_inicio" class="form-control form-control-sm has-calendar" aria-describedby="fecha_inicio" placeholder="fecha inicio" value="{{ $fissy->fecha_inicio }}" readonly>
                    </div>
                </div>
				<div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="fissy_tipo">Dias Pago</label>
                        <input name="dias_pago" id="dias_pago" class="form-control form-control-sm" aria-describedby="dias_pago" placeholder="dias pago" maxlength="10" value="{{ $fissy->dias_pago }}">
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <button class="btn btn-block bg-fissy text-white">Editar</button>
                </div>
        </div>
    </div>
  </div>
</div>
</form>
@endsection
