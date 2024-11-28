@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="table-responsive mt-3">
        <table id="users_table" class="table table-striped table-bordered table-sm" style="width:100%;">
            <thead class="">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Genero</th>
                    <th>Estrellas</th>
                    <th>Email</th>
                    <th>Código</th>
					<th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript">
   $(function () {
        $('#users_table').addClass( 'nowrap' )
        .DataTable({
            "processing":true,
            "serverSide":true,
            "responsive": true,
            /*"columnDefs": [
						{ targets: [-1, -3], className: 'dt-body-right' }
					],*/
            "ajax": "{{route('list_users')}}",
            "columns":[
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'genero', name:'genero', "sClass": "text-center" },
                { data: 'stars', name:'stars', orderable: false, "sClass": "text-center"},
                { data: 'email', name:'email'},
                { data: 'codigo', name:'codigo'},
				{ data: 'acciones', orderable: false}
            ],
            "dom": 'Blfrtip',
            "buttons": [ 'excel', 'pdf', 'copy' ],
            "language": {
            "url": "{{asset('i18n/datatables/Spanish.json')}}"
        }            
        });
    } );
    $('.has-calendar').datepicker({
        showOtherMonths: true,
        format: 'yyyy-mm-dd'
        //uiLibrary: 'bootstrap4'
    }); 
</script>
@endsection