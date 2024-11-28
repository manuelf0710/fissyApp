<button type="button" class="btn btn-sm bg-fissy text-white showmodalfissy"  data-url="{{route('fissy_plan', $id)}}" data-target="#modal-fissy-details" >Detalles</button>
@if(Auth::user()->perfil_id == 1)
<a href="{{route('fissy_edit', $id)}}" class="btn btn-sm btn-secondary">Editar</a>
@endif