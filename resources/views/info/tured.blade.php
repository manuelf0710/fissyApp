@if($usuario->referido == null)
<div class="container">
    <div class="alert alert-warning mt-2 font-weight-bold">
        no tienes un código de referido para crear tu red, debes ingresar el código que te proporciona la persona que te recomienda.
    </div>
    @include('info/solicitar_referido')
</div>
@endif
@if($total_notificaciones > 0)
<div class="container">
    <div class="alert alert-info">
        @foreach($notificaciones as $noti)
            @if($noti->tipo == 'contacto' && $noti->total > 0)
            <p>Tienes <b>{{$noti->total}}</b> solicitudes de contacto por aprobar <a href="{{route('aprobar_contacto_lista')}}" class="font-weight-bold">ingresar</a></p>
            @endif
            @if($noti->tipo == 'referidos' && $noti->total > 0)
            <p>Tienes <b>{{$noti->total}}</b> solicitudes de referencia por aprobar <a href="{{route('aprobar_referido_lista')}}" class="font-weight-bold">ingresar</a></p>
            @endif            
        @endforeach
    </div>
</div>
@endif
@if($usuario->referido != null)
    <div class="text-center mt-4 text-fissy font-weight-bold">
        <div class="col-md-12">
                <!--<div class="card" style="max-width:350px !important;">-->
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        
                        @if($tiene_referido)
                            <div class="text-fissy font-weight-bold text-center fz-11">Recomendado Por
                                <div class="text-center mt-2">
                                    @if($referido->avatar != NULL)
                                    <img src="{{asset('avatar/'.$referido->avatar)}}" alt="avatar" width="40" height="40" style="border-radius:50%; border:solid 2px #dcdcdc;">
                                    @else 
                                    <i class="fa fa-user fa-3x" style="color:#b2b1b0"></i>
                                    @endif                 
                                    <p class="text-fissy">{{$referido->name}}</p>
                                </div>
                            </div>
                        @endif
                        
                    <hr>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-sm bg-fissy text-white fz-11 d-none" type="button">Oportunidades de mejora</button>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 mb-5" >

                    @if( $usuario->avatar != NULL)
                    <img src="{{asset('avatar/'.$usuario->avatar)}}" alt="avatar" width="35" height="35" style="border-radius:50%; border:solid 2px #dcdcdc;">
                    @else 
                    <img src="{{asset('img/default-avatar.png')}}" alt="" width="35" height="35">
                    @endif
                    <p class="fz-11 text-fissy">Tú Contactos</p>
                    <p>Contactos</p>
                    <button class="btn btn-sm font-weight-bold bg-fissy fz-11 text-white" style="width:150px;" data-toggle="modal" data-target="#modalconectar">Conectar con alguién</button>                    
                    

                </div>
                <div class="col-md-10">
                    <div class="row " style="border-top:solid 1px #efebeb; margin-top:-1.2em;">
                        @foreach($contactos as $r)
                        
                            <div class=" col-md-2 col-sm-4 col-lg-2 mt-3 text-center text-fissy font-weight-bold lineindicator">
                                @if( $r->avatar != NULL)
                                <img src="{{asset('avatar/'.$r->avatar)}}" alt="avatar" width="35" height="35" style="border-radius:50%; border:solid 2px #dcdcdc;">
                                @else 
                               <img src="{{asset('img/default-avatar.png')}}" alt="" width="35" height="35">
                                @endif 
                                <p class="text-fissy" style="font-size:11px">{{$r->name}}</p>
                            </div>
                        @endforeach
                        </div>         
                </div>
                </div>


                <div class="row pd-2">
                    <div class="col-md-2 mb-5" >
                        <div>
                            <i class="fa fa-2x fa-arrows-alt" style="color:#a59f9f;"></i>
                        </div>
                        <p>Recomendados</p>
                        <button id="btn-recomendar" data-toggle="collapse" onclick="goToScroll('collapseinvitarporemail')" href="#collapseinvitarporemail" class="btn btn-sm font-weight-bold bg-fissy fz-11 text-white" style="width:150px;">Recomendar a alguién</button>                        
    
                    </div>
                    <div class="col-md-10">
                        <div class="row " style="border-top:solid 1px #efebeb; margin-top:-1.2em;">
                            @foreach($recomendados as $r)
                            
                                <div class=" col-md-2 col-sm-4 col-lg-2 mt-3 text-center text-fissy font-weight-bold lineindicator">
                                    @if( $r->avatar != NULL)
                                    <img src="{{asset('avatar/'.$r->avatar)}}" alt="avatar" width="35" height="35" style="border-radius:50%; border:solid 2px #dcdcdc;">
                                    @else 
                                   <img src="{{asset('img/default-avatar.png')}}" alt="" width="35" height="35">
                                    @endif 
                                    <p class="text-fissy" style="font-size:11px">{{$r->name}}</p>
                                </div>
                            @endforeach
                            </div>         
                    </div>
                    </div>                

                        <div class="d-none">
                            <div class="ml-2d">
                                
                                <div class="row">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                        <div class="col-md-4">
                                            <button id="btn-recomendar" data-toggle="collapse" href="#collapseinvitarporemail" class="btn btn-sm font-weight-bold bg-fissy fz-11 text-white d-none" style="width:150px;">Recomendar a alguién</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-sm font-weight-bold bg-fissy fz-11 text-white d-none" style="width:150px;" data-toggle="modal" data-target="#modalconectar">Conectar con alguién</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-sm font-weight-bold bg-fissy fz-11 text-white d-none" style="width:150px;">el item 8.3</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @endif