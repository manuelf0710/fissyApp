 @if($usuario->codigo != null)
	  @if($usuario->referido != null)
<div class="alert alert-info mt-3 font-weight-bold">
    Recomienda Fi$$y con los más confiables con el código: 
  {{$usuario->codigo}} invitar 
  <a data-toggle="collapse" href="#collapseinvitarporemail" role="button" aria-expanded="false" aria-controls="collapseinvitarporemail">
    mediante correo electrónico
  </a>
 
</div>
@else
	<div class="alert alert-info mt-3 font-weight-bold">
		Tú codigo de Fi$$y es {{$usuario->codigo}}
	</div>
@endif
<form action="{{route('invitar_fissy')}}" name="form_invitado" id="form_invitado" method="post">
    @csrf
    <div class="collapse" id="collapseinvitarporemail">
        <div class="cadrd card-bdody" >
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email_invitado">Invitar mediante email</label>
                </div>
            </div>
            <div class="input-group input-group-sm mb-3 col-md-12">
                <input type="email" name="email_invitado" id="email_invitado" value="" class="form-control form-control-sm" required>
                <div class="input-group-append">
                  <button class="input-group-text bg-fissy text-white"><i class="fa fa-send-o"></i></button>
                </div>
              </div> 
        </div>
    </div>
   
</form> 
@endif 