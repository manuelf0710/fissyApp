@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Aprobar Solicitudes </p>
	</nav>
	<form action="{{route('aprobar_referido')}}" name="form1" id="form1"  method="post" >
		@csrf
    <div class="row">
        <div class="col-md-8 offset-md-2">
		@if($type == 'email')
			<div class="alert alert-info" role="alert">
		      @if($status == 1)
				<p><strong>Se ha aprobado correctamente a la persona: {{$lista->name}}</strong></p>
			   @endif
				
			</div>
		@endif		
		@if($type == 'expired')
			<div class="alert alert-warning" role="alert">
				<p><strong>La solitud de aprobación ya no se encuentra disponible</strong></p>
				
			</div>
		@endif
			<div class="table-responsive">
			<table class="table">
				<thead>
					@if($type != 'expired' && $type != 'email')
					<tr>
						<th></th>
						<th>Nombre</th>
						<th>Correo Electrónico</th>
						<th></th>
					</tr>
					@endif
				</thead>
				<tbody>
					@if($type == 'web')
					@foreach($lista as $item)
					<tr>
						<td></td>
						<td>{{$item->name}}</td>
						<td>{{$item->email}}</td>
						<td>
							<button class="btn btn-sm bg-fissy text-white  btn-confirm-contact" data-action="2" data-contacto="{{$item->id}}" onclick="setValueContacto('2','{{$item->id}}');">Aprobar <i class="fa fa-check"></i></button>
							<button class="btn btn-sm btn-danger text-white  btn-noconfirm-contact" data-action="3" data-contacto="{{$item->id}}" onclick="setValueContacto('3','{{$item->id}}');">No Aprobar <i class="fa fa-close"></i></button>
						</td>
					</tr>
					@endforeach
					@endif				
				</tbody>
			</table>
			<input type="hidden" name="data_action" id="data_action" value="" >
			<input type="hidden" name="data_contacto" id="data_contacto" value="" >			
			</div>
			@if($type == 'web')
          <nav aria-label="Page navigation example mt-5">
            <ul class="pagination justify-content-center mt-5">
                {{ $lista->appends(request()->except('page'))->links() }}
            </ul>
           </nav> 			
		   @endif
        </div>
	</div>
	</form>   
</div>
@endsection
