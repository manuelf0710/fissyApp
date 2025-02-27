@extends('layouts.app')

@section('content')
<nav class="navbar navbar-light bg-fissy py-4 mb-4">
    <p></p>
</nav>
<div class="container-fluid mt-n4" >
    <div class="row justify-content-center">
        <div class="col-md-5 col-sm-12 col-xl-3">
                <div class="card-body rounded" >
                    <div class="col-md-12 mb-3 mt-5">
                        <p class="font-weight-bold">Ingresa a tu red social financiera</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <span class="form-check-label" for="remember">
                                        {{ __('Mantener conectado') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-fissy btn-lg">
                                            {{ __('Iniciar Sesión') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-fissy-light btn-lg" href="{{ route('register') }}">
                                            {{ __('Registro') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Has olvidado tu contraseña?') }}
                                        </a>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <!--
                    <div class="col-md-12 mb-3">
                        <div class="form-group mb-0 mt-2">
                            <div class="col-md-12">
                                <div id="openid-buttons" class="mx-auto grid grid__fl1 fd-column gs8 gsy mb16 wmx3">
                                    <button class="grid--cell btn btn-block btn-google" data-provider="google" data-oauthserver="https://accounts.google.com/o/oauth2/auth" data-oauthversion="2.0">
                                        <svg aria-hidden="true" class="native svg-icon iconGoogle" width="18" height="18" viewBox="0 0 18 18"><path d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 002.38-5.88c0-.57-.05-.66-.15-1.18z" fill="#4285F4"></path><path d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 01-7.18-2.54H1.83v2.07A8 8 0 008.98 17z" fill="#34A853"></path><path d="M4.5 10.52a4.8 4.8 0 010-3.04V5.41H1.83a8 8 0 000 7.18l2.67-2.07z" fill="#FBBC05"></path><path d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 001.83 5.4L4.5 7.49a4.77 4.77 0 014.48-3.3z" fill="#EA4335"></path></svg>
                            Continuar con Google        </button>
                                    <button class="btn btn-block btn-facebook" style=" color:#ffffff !important;" data-provider="facebook" data-oauthserver="https://www.facebook.com/v2.0/dialog/oauth" data-oauthversion="2.0">
                                        <i class="fa fa-facebook"></i>
                            Continuar con Facebook        </button>
                            </div>                                   
                            </div>
                        </div>
                    </div>-->                    
                </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xl-9" style="padding-right:0 !important;">
            <div class="backgroundinicio container" style="height:100%"> 
                <div class="vh-100 row text-center align-items-center justify-content-center">
                    <div class="col-md-4 offset-md-4">
                        <p class="font-weight-bold text-center">Simuladores</p>
                        <div class="col-auto ">
                        <a class="btn btn-fissy btn-lg mb-1 pd-3 " href="{{ route('register') }}">
                            Simula tus rendimientos
                        </a>
                        <a class="btn btn-fissy btn-lg mb-1" href="{{ route('register') }}">
                            Simula tu ayuda financiera
                        </a>
                        <a class="btn btn-fissy btn-lg mb-1" href="{{ route('register') }}">
                            arriendo vs compra de inmuebles
                        </a>
                        <a class="btn btn-fissy btn-lg mb-1" href="{{ route('register') }}">
                            Comprar o rentar vehículo
                        </a>
                    </div>
                        <p class="font-weight-bold text-center">Realiza tus pagos aquí</p>
                        
                    </div>    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
