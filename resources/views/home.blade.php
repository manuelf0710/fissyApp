<?php /* @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
*/?>
@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<div class="sticky-container">
    <div class="sticky">
        <div class="li">
            <i class="fa fa-angle-double-left fa-2x" style="right: 0;position: fixed;top: 45%; color:#1cb89e; z-index:-1;"></i>
            <div id="sidebar" style="width:260px; background:#333;">
                <div class="view-perfil-dashboard-user pl-5 pr-5 pt-2">
                    <div class="image-navmenu-dashboard-user" >
                        @if( $usuario->avatar != NULL)
                        <img src="{{asset('avatar/'.$usuario->avatar)}}" alt="avatar" width="50" height="50" style="border-radius:50%; border:solid 2px #dcdcdc;">
                        @else 
                        <i class="fa fa-user fa-4x" style="color:#b2b1b0"></i>
                        @endif 
        
                        
                    </div>
                    <h6 class="text-white mt-2 text-center"><b>{{ $usuario->name }}</b></h6>
                    <div class="stars-puntaje-dashboard-user text-center fz-11">
                        @for($i = 0; $i < $usuario->stars; $i++)
                        <span class="fa fa-star checked"></span>
                        @endfor
                        
                    </div>
                    <div class="text-center">
                        <span class="text-white text-center">Nivel: <b>{{  $usuario->stars }}/10</b></span>
                        <br>
                        <small style="color: white;">Eres un <b>({{ Auth::user()->perfil->nombre}})</b></small>
                        <br>
                        <!--<small style="color: white;">{{ Auth::user()->perfil->informacion}}</small>-->
                        <small style="color: white;">{{ Auth::user()->email}}</small>
                        <br><br>
                        <!--<a href="https://www.myfissy.com/login/administrador" class="btn btn-fissy">Administrar</a>-->
                        <br><br>
                        <!--<p style="color: white">Esta cuenta es <b style="color: #1cb89e;">Premium</b></p>-->
                    </div>
                </div>
                <div class="bg-fissy text-white p-2 text-center" >
                    Mi red
                </div>
                @if($tiene_referido)
                <div class="row">
                    <div class="text-white text-center col-md-12">Te recomendó</div>
                    @if($referido->avatar != NULL)
                    
                    <div class="text-center mt-2 col-md-12">
                        <img src="{{asset('avatar/'.$referido->avatar)}}" alt="avatar" width="40" height="40" style="border-radius:50%; border:solid 2px #dcdcdc; margin-left: 40% !important;">
                    </div>
                    @else 
                    <div class="text-center mt-2 col-md-12">
                        <i class="fa fa-user fa-4x" style="color:#b2b1b0"></i>
                    </div>
                   
                    @endif                 
                    <div class="text-light text-center col-md-12 fz-11">{{$referido->name}}</div>
                </div>
                @endif  
                <div style="clear:both;"></div>
                <div class="row">
                    <div class="col-md-12">
                        @if( $usuario->avatar != NULL)
                        <img src="{{asset('avatar/'.$usuario->avatar)}}" alt="avatar" width="30" height="30" style="border-radius:50%; border:solid 2px #dcdcdc;">
                        @else 
                        <i class="fa fa-user fa-4x" style="color:#b2b1b0"></i>
                        @endif 
                       <div class="text-right text-white">Tú</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-md navbar-dark bg-fissy fixed-top" style="top:70px; z-index:1; min-height: 92px !important;">
    <span class="navbar-brand text-light">
        
    </span>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav nav-pills pt-2 justify-content-center" id="pills-tab" role="tablist">            
            <li class="nav-item mr-3" role="presentation">
                <a class="nav-link btn-fissy @if($usuario->codigo!='' && request()->get('tab') != 'myd') active @endif text-white" id="pills-dashboard-tab" data-toggle="pill" href="#pills-dashboard" role="tab" aria-controls="pills-dashboard" aria-selected="true">Tablero Principal </a>
            </li>                
            <li class="nav-item mr-3" role="presentation">
                <a class="nav-link btn-fissy text-white" id="pills-home-tab" data-toggle="pill" href="#pills-misfissys" role="tab" aria-controls="pills-home" aria-selected="true">Mis Fi$$ys</a>
            </li>
            <li class="nav-item mr-3" role="presentation">
                <a class="nav-link  btn-fissy text-white" id="pills-contact-tab" data-toggle="pill" href="#pills-reporte" role="tab" aria-controls="pills-contact" aria-selected="false">Reporte</a>
            </li>
            <li class="nav-item mr-3" role="presentation">
            <a class="nav-link  btn-fissy text-white" id="pills-tured-tab" data-toggle="pill" href="#pills-tured" role="tab" aria-controls="pills-tured" aria-selected="false">Tu Red @if($total_notificaciones > 0) <span class="badge badge-danger">{{$total_notificaciones}}</span> @endif</a>
            </li>                
        </ul>
    </div>
  </nav><!-- NavBar END -->
  
  
  <!-- Bootstrap row -->
  <div class="row" id="body-row"> 
      <!-- MAIN -->
      <div class="col">
          
        <div class="content" style="margin-top:5em">
            <div class="container-fluisd vh-100">
                <div class="row ">
                    <div class="col-md-3 bg-fissy mt-2">
                        
                    </div>
                    <div class="col-md-9 bg-fissy">
 
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="col-md-12">
                                @include('info/invitacion_email')
                            </div>
                          
                            <div class="tab-pane fade " id="pills-misfissys" role="tabpanel" aria-labelledby="pills-misfissys-tab">
                                <div class="container">
                                    tab mys fissys
                                </div>
                            </div>
                            <div class="tab-pane fade @if($usuario->codigo!='' && request()->get('tab') != 'myd') show active @endif " id="pills-dashboard" role="tabpanel" aria-labelledby="pills-misfissys-tab">
                                <div class="container">
                                @include('info/tablero')
                                </div>
                            </div>                                
                            <div class="tab-pane fade " id="pills-reporte" role="tabpanel" aria-labelledby="pills-reporte-tab">
                                Contenido de reporte
                            </div>
                           
                            <div class="tab-pane fade" id="pills-reporte" role="tabpanel" aria-labelledby="pills-reporte-tab">
                                contenido de reporte
                            </div>
                            <div class="tab-pane fade " id="pills-tured" role="tabpanel" aria-labelledby="pills-tured-tab">
                                <div class="ml-2n">
                                    @include('info/tured')
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
            
                
            </div>
        </div>
  
  
      </div><!-- Main Col END -->
      
  </div><!-- body-row END -->
@endsection
