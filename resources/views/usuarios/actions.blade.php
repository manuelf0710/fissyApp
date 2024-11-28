@if(Auth::user()->perfil_id == 1)
<a class="btn btn-sm btn-success" href="{{route('user_admin_edit', $id)}}" title="editar"><i class="fa fa-pencil"></i></a>
@endif