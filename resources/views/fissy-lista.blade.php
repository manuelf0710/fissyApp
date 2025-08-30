@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<div class="container-fluid">
  <form name="form_filto_fissy" id="form_filto_fissy">
    @csrf
	  <table  class="table-responsive mt-3 " border="0" cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td>Minimo monto:</td>
				<td><input type="text" id="monto_min" name="monto_min" class="form-control form-control-sm"></td>
				<td>Máximo monto:</td>
				<td><input type="text" id="monto_max" name="monto_max" class="form-control form-control-sm"></td>				
			</tr>
			<tr>
				<td>Minimo tasa:</td>
				<td><input type="text" id="tasa_min" name="tasa_min" class="form-control form-control-sm"></td>
				<td>Máximo tasa:</td>
				<td><input type="text" id="tasa_max" name="tasa_max" class="form-control form-control-sm"></td>
			</tr>
			<tr>
				<td>Fi$$ys</td>
				<td>
					<select name="propietario" id="propietario" class="form-control form-control-sm">
						<option value="">Todos</option>
						<option value="1">Mis Fi$$ys</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><button class="btn btn-sm bg-fissy text-white" type="button" name="btn-filtrado" id="btn-filtrado">Filtrar <i class="fa fa-filter"></i></button>
				<input type="hidden" id="input_negociado" value="{{route('fissy_list2', '1')}}">
				<input type="hidden" id="input_otros" value="{{route('fissy_list2', 200)}}">
				</td>
			</tr>
		</tbody>
	</table>
  </form>  
  <div class="table-responsive mt-3">
    <div class="row">
      <div class="col-md-12 text-center">
        <button class="btn btn-lg bg-fissy text-white" onclick="location.href='{{route('fissy_crear')}}'">Nuevo Fissy <i class="fa fa-plus-circle"></i></button>
      </div>
    </div>
	<!-- fissys estado 7,8 disponible,negociado-->
      <table id="fissy_table_disponible" class="table table-striped table-bordered table-sm" style="width:100%;">
          <thead class="text-center bg-fissy text-white">
              <tr>
                  <th>Id</th>
				          <th>Puntaje</th>
                  <th align="center">Monto</th>
                  <th>Tasa</th>
                  <th>Periodo</th>
                  <th>Estado</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
      </table>
	  <!-- fissys otros estados menos finalizado-->
      <table id="fissy_table_otros" class="table table-striped table-bordered table-sm" style="width:100%;">
          <thead class="text-center bg-fissy text-white">
              <tr>
                  <th>Id</th>
				          <th>Puntaje</th>
                  <th align="center">Monto</th>
                  <th>Tasa</th>
                  <th>Periodo</th>
                  <th>Estado</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
      </table>	  
  </div>
  <!--<button class="btn btn-lg bg-fissy text-white btn-fixed-br" onclick="location.href='{{route('fissy_crear')}}'">Nuevo Fissy <i class="fa fa-plus-circle"></i></button>-->
</div>
<div class="modal fade" id="modal-fissy-details" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-fissy-details-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fissy Detalles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

      </div>

    </div>
  </div>
</div>
<script type="text/javascript">
 $(function () {
    $.fn.dataTable.ext.errMode = 'throw';
	
	fill_datatable();
	fill_datatable_otros();
	
  function fill_datatable()
  {
   const type_negociado = 1;
   var dataTable = $('#fissy_table_disponible').DataTable({
    "processing" : true,
    "serverSide" : true,
    "searching" : false,
    "responsive": true,
    "ajax" : {
     url:"{{route('fissy_list2', 1)}}?"+$("#form_filto_fissy").serialize(),
     type:"GET",
     data:{
      //monto_min:monto_min, monto_max:monto_max
     }
    },
    "order": [[ 0, "desc" ]],
          "columns":[
              {data:'id', visible: false},
              { data: 'stars',
                name:'stars',
                orderable:false,
                searchable:false,
				render: function (data, type, row) {
					estrellas = '';
					for(i = 1; i <= row.stars; i++){
							estrellas += "<i class='fa fa-star text-fissy'></i>";
					}
					return '<code>'+estrellas+'</code>';
                }  
              },
              { data: 'monto',
                name: 'monto', 
				        className: 'text-right',
                //render:$.fn.dataTable.render.number( '.', ',', 2, '$' )
                render: function(data, type, row) {
                  const simbolo = row.simbolo || '';
                  // Formateo simple manual
                  const montoFormateado = Number(data).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  });
                  return simbolo + ' ' + montoFormateado;
                }                
              },
              { data: 'interes', name: 'interes', "sClass": "text-center"  },
              { data: 'periodo', name:'periodo', "sClass": "text-center" },
              { 
                data: 'estado', 
                name:'estado',
                orderable:false,
                searchable:false,
                "sClass": "text-center",
                render: function (data, type, row) {
                   return row.estado_des;

                }
              },
              { data: 'acciones', orderable: false, "sClass": "text-center" }

              //{ data: 'name', name:'name', orderable:false}                            
          ],
		  "language": {
			"url": "{{asset('i18n/datatables/Spanish.json')}}"
			}
   });
  }	
  
  function fill_datatable_otros()
  {
   const type_otros = 2;
   var dataTable = $('#fissy_table_otros').DataTable({
    "processing" : true,
    "serverSide" : true,
    "searching" : false,
    "responsive": true,
    "ajax" : {
     url:"{{route('fissy_list2',2)}}?"+$("#form_filto_fissy").serialize(),
     type:"GET",
     data:{
      //monto_min:monto_min, monto_max:monto_max
     }
    },
    "order": [[ 0, "desc" ]],
          "columns":[
              {data:'id', visible: false},
              { data: 'stars',
                name:'stars',
                orderable:false,
                searchable:false,
				render: function (data, type, row) {
					estrellas = '';
					for(i = 1; i <= row.stars; i++){
							estrellas += "<i class='fa fa-star text-fissy'></i>";
					}
					return '<code>'+estrellas+'</code>';
                }  
              },
              { data: 'monto',
                name: 'monto', 
				className: 'text-right',
               /* render: function (data, type, row) {
                   return '$'+row.monto;

                }*/
                render:$.fn.dataTable.render.number( '.', ',', 2, '$' )
              },
              { data: 'interes', name: 'interes', "sClass": "text-center"  },
              { data: 'periodo', name:'periodo', "sClass": "text-center" },
             
 
              { 
                data: 'estado', 
                name:'estado',
                orderable:false,
                searchable:false,
                "sClass": "text-center",
                render: function (data, type, row) {
                   return row.estado_des;

                }
              },
              { data: 'acciones', orderable: false, "sClass": "text-center" }

              //{ data: 'name', name:'name', orderable:false}                            
          ],
		  "language": {
			"url": "{{asset('i18n/datatables/Spanish.json')}}"
			}
   });
  }	  
  
    $('#btn-filtrado').click(function(){
    $('#fissy_table_disponible').DataTable().destroy();
    fill_datatable();
    $('#fissy_table_otros').DataTable().destroy();
    fill_datatable_otros();	
  });
   
	/*
     var table = $('#fissy_table_disponible').addClass( 'nowrap' )
      .DataTable({
          "processing":true,
          "serverSide":true,
          "responsive": true,
          "columnDefs": [
          { targets: [-1, -3], className: 'dt-body-right' }
        ],
          "ajax": {
                url: "{{route('fissy_list')}}",
                type:'GET'
          }, 
          "columns":[
              { data: 'id', name: 'id'},
              { data: 'monto',
                name: 'monto', 
                orderable:false,
                render: function (data, type, row) {
                   return '$'+row.monto;

                }
              },
              { data: 'interes', name: 'interes', orderable:false},
              { data: 'periodo', name:'periodo', "sClass": "text-center" },
              { data: 'pago_mensual',
                name:'pago_mensual', 
                orderable: false,
                searchable:false,
                render: function (data, type, row) {
                   return '$'+row.pago_mensual;

                }
              },
              { data: 'pago_final',
                name:'pago_final',
                orderable:false,
                searchable:false,
                render: function (data, type, row) {
                   return '$'+row.pago_final;

                }                
              },
              { data: 'created_at', name:'created_at'},
              { 
                data: 'estado', 
                name:'estado',
                orderable:false,
                searchable:false,
                render: function (data, type, row) {
                   return row.estado_des;

                }
              },
              { data: 'stars',
                name:'stars',
                orderable:false,
                searchable:false
              },
              { data: 'name', name:'name', orderable:false}                            
          ],
          "dom": 'Blfrtip',
          "buttons": [ 'excel', 'pdf', 'copy' ],
          "language": {
          "url": "{{asset('i18n/datatables/Spanish.json')}}"
      }            
      });
	  
	  */
	  
	  $('.has-calendar').datepicker({
		  showOtherMonths: true,
		  format: 'yyyy-mm-dd'
		  //uiLibrary: 'bootstrap4'
	  }); 
      
  });

</script>
@endsection
