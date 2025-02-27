@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-4 mb-4">
    <p></p>
</nav>-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12 col-xl-6">
                <div class="card-body">
                    <!--<div class="col-md-12">
                        <div class="form-group mb-0 mt-2">
                            <div class="col-md-6 offset-md-4">
                                <div id="openid-buttons" class="mx-auto grid grid__fl1 fd-column gs8 gsy mb16 wmx3">
                                    <button class="grid--cell btn btn-block btn-google" data-provider="google" data-oauthserver="https://accounts.google.com/o/oauth2/auth" data-oauthversion="2.0">
                                        <svg aria-hidden="true" class="native svg-icon iconGoogle" width="18" height="18" viewBox="0 0 18 18"><path d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 002.38-5.88c0-.57-.05-.66-.15-1.18z" fill="#4285F4"></path><path d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 01-7.18-2.54H1.83v2.07A8 8 0 008.98 17z" fill="#34A853"></path><path d="M4.5 10.52a4.8 4.8 0 010-3.04V5.41H1.83a8 8 0 000 7.18l2.67-2.07z" fill="#FBBC05"></path><path d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 001.83 5.4L4.5 7.49a4.77 4.77 0 014.48-3.3z" fill="#EA4335"></path></svg>
                            Continuar con Google        </button>
                                    <button class="btn btn-block btn-facebook" style=" color:#ffffff !important;" data-provider="facebook" data-oauthserver="https://www.facebook.com/v2.0/dialog/oauth" data-oauthversion="2.0">
                                        <i class="fa fa-facebook"></i>
                            Continuar con Facebook        </button>
                            </div>                                   
                            </div>
                        </div> -->
                    </div>                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class=" col-form-label">{{ __('Nombre') }}</label>

                                        <input id="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celular" class=" col-form-label text-md-right">{{ __('Celular') }}</label>
                                        <input id="celular" type="number" class="form-control form-control-sm @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular">

                                        @error('celular')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class=" col-form-label text-md-right">{{ __('Correo Electronico') }}</label>
                                        <input id="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ request()->has('email') ? request()->get('email') : old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class=" col-form-label text-md-right">{{ __('Confirmar  Correo Electronico') }}</label>
                                        <input id="confirmar_email" type="email" class="form-control form-control-sm @error('confirmar_email') is-invalid @enderror" name="confirmar_email" value="{{ old('confirmar_email') }}" required autocomplete="confirmar_email">

                                        @error('confirmar_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>                            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirmar Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="referido" class=" col-form-label text-md-right">{{ __('Referido Por') }} <span class="fz-11">(si te han proporcionado un codigo de referido ingresalo aquí)</span></label>
                                    <input id="referido" type="referido" class="form-control form-control-sm" name="referido"  autocomplete="referido" value="{{ request()->has('t') ? request()->get('t') : old('referido') }}">
                                    <input type="hidden" name="t2" id="t2" value="{{ request()->has('t2') ? request()->get('t2') : old('t2') }}">
                                    <input type="hidden" name="ref" id="ref" value="{{ request()->has('ref') ? request()->get('ref') : old('ref') }}">
                            </div>                            
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="politicaprivacidad" for="politicaprivacidad" class=" col-form-label text-md-right font-weight-bold" data-toggle="modal" data-target="#modalpoliticaprivacidad">Mostrar la política de privacidad</label>
                               <p class="text-muted" style="font-size:13px">
                               <input type="checkbox" name="politicachk" id="politicachk"  required> Por favor, confirma que estás de acuerdo con nuestra política de privacidad
                               </p>
                            </div>                             
    
                        </div>

                        <div class="col-md-12 mt-1">
                            <div class="form-group">
                                <label for="captcha" class="font-weight-bold">CAPTCHA</label>
                                <div class="input-group">
                                    <input id="captcha" type="text" class="form-control form-control-sm" name="captcha" required>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <img id="captcha-image" src="{{ captcha_src() }}" alt="CAPTCHA">
                                    <a href="javascript:void(0)" id="refresh-captcha" class="ml-3">⟳ Recargar CAPTCHA</a>
                                    @if ($errors->has('captcha'))
                                        <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center mt-1 mb-4">
                                <button type="submit" class="btn btn-fissy px-4 py-2">
                                    {{ __('Registrarse') }}
                                </button>
                            </div>
                        </div>
                                               
                    </div>
                    </form>
                </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalpoliticaprivacidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Política de Privacidad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="um-field um-field-type_terms_conditions" data-key="use_terms_conditions_agreement" style="display:block;padding:0;">
                <div class="um-field-area">
                    <div class="um-gdpr-content" style="display: block;">
                        <!-- wp:heading -->
            <h2>Quiénes somos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>La dirección de nuestra web es: https://www.myfissy.com.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading -->
            <h2>Qué datos personales recogemos y por qué los recogemos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Comentarios</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Cuando los visitantes dejan comentarios en la web, recopilamos los datos que se muestran en el formulario de comentarios, así como la dirección IP del visitante y la cadena de agentes de usuario del navegador para ayudar a la detección de spam.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>Una cadena anónima creada a partir de tu dirección de correo electrónico (también llamada hash) puede ser proporcionada al servicio de Gravatar para ver si la estás usando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de tu comentario, la imagen de tu perfil es visible para el público en el contexto de su comentario.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Medios</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Si subes imágenes a la web deberías evitar subir imágenes con datos de ubicación (GPS EXIF) incluidos. Los visitantes de la web pueden descargar y extraer cualquier dato de localización de las imágenes de la web.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Formularios de contacto</h3>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Cookies</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Si dejas un comentario en nuestro sitio puedes elegir guardar tu nombre, dirección de correo electrónico y web en cookies. Esto es para tu comodidad, para que no tengas que volver a rellenar tus datos cuando dejes otro comentario. Estas cookies tendrán una duración de un año.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>Si tienes una cuenta y te conectas a este sitio, instalaremos una cookie temporal para determinar si tu navegador acepta cookies. Esta cookie no contiene datos personales y se elimina al cerrar el navegador.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>Cuando inicias sesión, también instalaremos varias cookies para guardar tu información de inicio de sesión y tus opciones de visualización de pantalla. Las cookies de inicio de sesión duran dos días, y las cookies de opciones de pantalla duran un año. Si seleccionas "Recordarme", tu inicio de sesión perdurará durante dos semanas. Si sales de tu cuenta, las cookies de inicio de sesión se eliminarán.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>Si editas o publicas un artículo se guardará una cookie adicional en tu navegador. Esta cookie no incluye datos personales y simplemente indica el ID del artículo que acabas de editar. Caduca después de 1 día.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Contenido incrustado de otros sitios web</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Los artículos de este sitio pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras web se comporta exactamente de la misma manera que si el visitante hubiera visitado la otra web.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>Estas web pueden recopilar datos sobre ti, utilizar cookies, incrustar un seguimiento adicional de terceros, y supervisar tu interacción con ese contenido incrustado, incluido el seguimiento de tu interacción con el contenido incrustado si tienes una cuenta y estás conectado a esa web.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3} -->
            <h3>Analítica</h3>
            <!-- /wp:heading -->
            
            <!-- wp:heading -->
            <h2>Con quién compartimos tus datos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:heading -->
            <h2>Cuánto tiempo conservamos tus datos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Si dejas un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar comentarios sucesivos automáticamente en lugar de mantenerlos en una cola de moderación.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:paragraph -->
            <p>De los usuarios que se registran en nuestra web (si los hay), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores de la web también pueden ver y editar esa información.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading -->
            <h2>Qué derechos tienes sobre tus datos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Si tienes una cuenta o has dejado comentarios en esta web, puedes solicitar recibir un archivo de exportación de los datos personales que tenemos sobre ti, incluyendo cualquier dato que nos hayas proporcionado. También puedes solicitar que eliminemos cualquier dato personal que tengamos sobre ti. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading -->
            <h2>Dónde enviamos tus datos</h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph -->
            <p>Los comentarios de los visitantes puede que los revise un servicio de detección automática de spam.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading -->
            <h2>Tu información de contacto</h2>
            <!-- /wp:heading -->
            
            <!-- wp:heading -->
            <h2>Información adicional</h2>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h4>Cómo protegemos tus datos</h4>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h4>Qué procedimientos utilizamos contra las brechas de datos</h4>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h4>De qué terceros recibimos datos</h4>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h4>Qué tipo de toma de decisiones automatizada y/o perfilado hacemos con los datos del usuario</h4>
            <!-- /wp:heading -->
            
            <!-- wp:heading {"level":3} -->
            <h4 class="mb-4">Requerimientos regulatorios de revelación de información del sector</h4>
            <!-- /wp:heading -->		</div>
            
                    
                    <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close">Ocultar la política de privacidad</a>
                </div>
                <div class="um-field-area">
            

                    <div class="um-clear"></div>
            
                                        
                    <div class="um-clear"></div>
                </div>
            </div>



        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>
@endsection
