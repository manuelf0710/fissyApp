@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{route('fissy_store')}}" method="post" name="form_fissy" id="form_fissy">
<div class="container-fluids vh-100 p-1">
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
                        <select onchange="showInfoCards()" data- name="moneda" id="moneda" class="required form-control form-control-sm @error('moneda') is-invalid @enderror" aria-describedby="moneda" placeholder="tipo moneda" required>
                            <option value="">Seleccione...</option>
                            @foreach($monedas as $item)
                            <option value="{{$item->id}}" data-fulldata='@json($item)'>{{$item->nombre}}</option>
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
                    <input type="text" onchange="showInfoCards()" class="required form-control form-control-sm @error('monto') is-invalid @enderror" id="monto" name="monto" aria-describedby="monto" placeholder="monto" value="{{old('monto')}}" required>
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
                        <input type="number" onchange="showInfoCards()" class="required form-control form-control-sm @error('periodo') is-invalid @enderror" id="periodo" name="periodo" aria-describedby="periodo" placeholder="periodo" value="{{old('periodo')}}" required>
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
                        <input step="0.1" type="number" onchange="showInfoCards()" class="required form-control form-control-sm @error('interes') is-invalid @enderror" id="interes" name="interes" aria-describedby="interes" placeholder="interes" value="{{old('interes')}}" required>
                        @error('interes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span class="text-muted fz-11">*Utilizar punto para los decimales</span>
                    </div>
                </div> 
                <div class="col-md-6 col-sm-12 col-12" style="display:none;">
                    <div class="form-group">
                        <label for="fissy_tipo">Tipo de Pago</label>
                        <select name="tipo_pago" id="tipo_pago" class="required form-control form-control-sm @error('tipo_pago') is-invalid @enderror" aria-describedby="tipo_pago" placeholder="tipo pago" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipo_pagos as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        @error('tipo_pago')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                  <!--  <button class="btn btn-lg bg-fissy text-white fz-11" style="position: fixed; bottom: 2%; right: 1em; border-radius: 5px; font-size:1em; z-index:99;">Crear Fi$$y <i class="fa fa-send"></i></button> -->
        </div>
    </div>
    </div>
    <div class="container-fluid">
            <div class="card-group mt-5 mb-5" id="containertipopago" style="visibility:hidden;">
                <div class="col-md-4 col-sm-6 col-xs-6 pd-3 mb-4"> 
                    <div class="card shadow-card card-pago text-muted" data-id="4" id="cardtipopago4">
                        <button type="button" class="btn btn-block bg-fissy text-white" style="font-size:1em">Interes y Capital al final del periodo</button>
                        <div style="margin: 0 auto; text-align: center">
        
        
                        </div>              
                        <div class="card-body">
                            <div class="text-center">
                                <span class="montocard"></span>
                            </div>
                            <ul class="list-group list-group-flush" >
                                <li class="list-group-item">  Interes <span class="interescard"></span></li>
                                <li class="list-group-item"> Pago Mensual <span id="pagom4"></span></li>
                                <li class="list-group-item">Pago Final <span id="pagof4"></span></li>
                        </div>
                        </ul>                
                        <div class="card-footer">
                          
                        </div>            
                    </div>
                </div> 

                <div class="col-md-4 col-sm-6 col-xs-6 pd-3"> 
                    <div class="card shadow-card card-pago text-muted" data-id="5" id="cardtipopago5">
                        <button type="button" class="btn btn-block bg-fissy text-white" style="font-size:1em">Interes Mensual y capital al final</button>
                        <div style="margin: 0 auto; text-align: center">
        
        
                        </div>              
                        <div class="card-body">
                            <div class="text-center">
                                <span class="montocard"></span>
                            </div>
                            <ul class="list-group list-group-flush" >
                                <li class="list-group-item">  Interes <span class="interescard"></span></li>
                                <li class="list-group-item"> Pago Mensual <span id="pagom5"></span></li>
                                <li class="list-group-item">Pago Final <span id="pagof5"></span></li> 
                            </ul>                                  
                        </div>
                       
                                 
                        <div class="card-footer">
                            
                        </div>            
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 pd-3"> 
                    <div class="card shadow-card card-pago text-muted" data-id="6" id="cardtipopago6">
                        <button type="button" class="btn btn-block bg-fissy text-white" style="font-size:1em">interes y capital mensualmente</button>
                        <div style="margin: 0 auto; text-align: center">
        
        
                        </div>              
                        <div class="card-body">
                            <div class="text-center">
                                <span class="montocard"></span>
                            </div>
                            <ul class="list-group list-group-flush" >
                                <li class="list-group-item">  Interes <span class="interescard"></span></li>
                                <li class="list-group-item"> Pago Mensual <span id="pagom6"></span></li>
                                <li class="list-group-item">Pago Final <span id="pagof6"></span></li> 
                            </ul>                                  
                        </div>
                       
                                 
                        <div class="card-footer">
                            <!--<button class="btn btn-sm bg-fissy text-white btn-select-tipopago"  data-id="6">Seleccionar</button>-->
                        </div>            
                    </div>
                </div>                
            
        </div>             
</div>
</form>
@endsection
