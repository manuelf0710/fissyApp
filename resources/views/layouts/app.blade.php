<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('js/datepicker/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('js/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('js/datatables/Responsive-2.2.5/css/responsive.dataTables.min.css')}}">
	<link rel="icon" href="{{ asset('img/cropped-fissylogo-04-1-32x32.jpg') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('img/cropped-fissylogo-04-1-192x192.jpg') }}" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/cropped-fissylogo-04-1-180x180.jpg') }}" />      

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="{{ asset('js/popper.min.js') }}" ></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>    
    <script src="{{ asset('js/sweetalert2@9.js') }}"></script>
    <script src="{{ asset('js/select2/select2.min.js') }}" ></script>    
    <script src="{{ asset('js/fissy.js') }}" ></script>
    <script src="{{ asset('js/datepicker/gijgo.min.js')}}" type="text/javascript"></script>    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
	<style type="text/css">
        .swal2-styled {
        margin: .3125em;
        padding: .225em 2em;
        box-shadow: none;
        font-weight: 500;
        font-size:.9em !important;
    }
        </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand text-light" href="{{ url('/') }}">
					<img src="{{ asset('img/logo.png') }}" alt="logo" width="100">
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" id="main-navigation">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link text-light"><i class="fa fa-home"></i></a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link text-light">Sobre Fi$$y</a>
                            </li>
							<li class="nav-item">
                                <a href="{{route('view_table_fissy')}}" class="nav-link text-light">Oportunidades</a>
                            </li>                                                                       
							<li class="nav-item">
                                <a href="" class="nav-link text-light">Contacto</a>
							</li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->perfil_id == '1')
                                    <a class="dropdown-item" href="{{route('view_table_users')}}">Usuarios Lista</a>
									<a class="dropdown-item" href="{{route('gastos')}}">Excel Gastos</a>
                                    @endif
									<a class="dropdown-item" href="{{route('misdatos')}}">Mis Datos</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> 
        <div style="height:4em;"></div>
    <!-- Modal -->
    <form action="{{route('contacto_fissy')}}" method="post" name="form_contacto" id="form_contacto">  
        @csrf  
        <div class="modal fade" id="modalconectar" tabindex="-1" role="dialog" aria-labelledby="modalconectar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Contactar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="solicitar_contacto" class="text-dark" style="color:#777 !important;">Solicitar Contacto</label>
                        </div>
                        <select name="conectar[]" id="conectar" class="form-control form-control-sm ml-4"  style="width: 100%" required>
            
                        </select> 
                    </div>            
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button class="btn bg-fissy text-white">Enviar Solicitud</button>
                </div>
            </div>
            </div>
        </div>
    </form>        

        <main class="">
            @yield('content')
        </main>
    </div>
    @include('sweetalert::alert')
    <input type="hidden" name="rooturl" id="rooturl" value="{{URL::to('/')}}">
    <script type="text/javascript">
        $('.has-calendar').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd',
			 //footer: true
            //uiLibrary: 'bootstrap4'
        });    
    </script> 
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('js/datatables/Responsive-2.2.5/js/dataTables.responsive.min.js')}}"></script> 
    <script src="http://www.onextrapixel.com/examples/touch-swipe/jquery.touchSwipe.min.js"></script>  
</body>
</html>
