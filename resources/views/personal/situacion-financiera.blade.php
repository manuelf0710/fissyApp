@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{route('fissy_store')}}" method="post" name="form_fissy" id="form_fissy">
@csrf
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Tú situación Financiera</p>
    </nav>
    <div class="row">
        <div class="container-fluid">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12 pb-5 table-responsive">
                                        <h6 class="text-muted">Flujo de Caja Mensual - Gastos Fijos</h6>
                                        <table id="table_gastos" class="table table-sm table-bordered table-hover mb-5" height="150">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Fecha</th>
													<th>Detalle</th>
                                                    <th>Monto</th>
                                                    <th>Tipo</th>
                                                    <th>Estado</th>
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
											  </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table cellspacing="1">
                                            <thead class="thead-light">
                                                <tr class="text-muted fz-11">
                                                    <th class="SBRA2" style="width:50%">Disponible para gasto en efectivo o tarjeta crédito</th>
                                                    <th>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" class="form-control text-right" aria-label="Amount" value="0.00" readonly>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr class="text-muted fz-11">
                                                    <th class="SBRA2">Dinero recomendado para invertir</th>
                                                    <th>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" class="form-control text-right" aria-label="Amount" value="0.00" readonly>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h6 class="text-muted">Tú información financiera</h6>
                                <div class="row">
									<div class="offset-md-4 col-md-4 col-sm-4">
										<div>
											<div class="col-md-12 text-muted fz-11"> &nbsp;&nbsp;&nbsp; Agregar documentos soporte</div>
											<div class="col-md-12">
												<i class="fa-5x fa fa-folder folder-plus folder-add-documents"></i>
												
											</div>
										</div>
									</div>								
									
								</div>
								<div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div>
                                        <div class="col-md-12 text-muted fz-11">Hace tres meses</div>
                                        <div class="col-md-12">
                                            <i class="fa-5x fa fa-folder fa-gradient"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div>
                                        <div class="col-md-12 text-muted fz-11">Hace dos meses</div>
                                        <div class="col-md-12">
                                            <i class="fa-5x fa fa-folder fa-gradient"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div>
                                        <div class="col-md-12 text-muted fz-11"> &nbsp;&nbsp;&nbsp; mes Pasado</div>
                                        <div class="col-md-12">
                                            <i class="fa-5x fa fa-folder fa-gradient"></i>
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
							
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</form>
<form action="{{route('add_extractos')}}" method="post" name="form_extractos" id="form_extractos"  enctype="multipart/form-data">
@csrf
<div class="modal fade" id="modal-add-doc" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-add-doc-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cargue de archivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
		<div class="container">
			<div class="row justify-content-around">
				<div class="offset-md-2 col-md-8">
					<div class="row">
					
						<div class="form-group">
						<label for="nombre">Fecha</label></br>
						</div>						

						<div class="input-group mb-3">
						  <input type="text" name="fecha_documento_add" id="fecha_documento_add" class="form-control form-control-sm has-calendar" aria-label="calendar" readonly>
						  <div class="input-group-append">
							<span class="input-group-text" onclick="document.getElementById('fecha_documento_add').value='';">
								<i class="fa fa-close pull-right"></i>
							</span>
						  </div>
						</div>

					</div>				
				
					@foreach($tipo_documentos as $item)
					<div class="row">
						<div class="form-group bg-light p-2">
						<label for="nombre">{{ $item->nombre }}</label></br>
						<input type="file" name="documento_add_{{ $item->id }}" id="documento_add_{{ $item->id }}" required>
						</div>			
					</div>
					@endforeach
				</div>
				<div class="offset-md-2 col-md-8">
					<button class="btn bg-fissy text-white pull-right">Subir Archivos</button>
				</div>
			</div>			
		</div>
      </div>

    </div>
  </div>
</div>
</form>

<script type="text/javascript">
 $(function () {
    $.fn.dataTable.ext.errMode = 'throw';
	setTimeout(function(){ fill_datatable(); }, 300);
	
  function fill_datatable()
  {
   var dataTable = $('#table_gastos').DataTable({
    "processing" : true,
    "serverSide" : true,
    "searching" : false,
    "responsive": true,
	"order": [[ 0, "asc" ]],
	"iDisplayLength": 50,	
    "ajax" : {
     url:"{{route('gastos_lista')}}",
	 cache:false,
     type:"GET",
     data:{
      //monto_min:monto_min, monto_max:monto_max
     }
    },
          "columns":[
              { data: 'id',
                name:'id',
                orderable:true,
                searchable:false,
				visible:false		
              },	  
              { data: 'fecha',
                name:'fecha',
                orderable:false,
                searchable:false,
              },              
			  { data: 'detalle',
                name:'detalle',
                orderable:false,
                searchable:false,
              },
              { data: 'valor',
                name: 'valor', 
				className: 'text-right',
                render: function (data, type, row) {
                   return '$'+new Intl.NumberFormat("de-DE").format(row.valor);

                }				
              },
              { data: 'tipo_des',
                name:'tipo_des',
                orderable:false,
                searchable:false,
				className: 'text-right'               
              },
              { data: 'estado_des', name:'estado_des', "sClass": "text-center" }

              //{ data: 'name', name:'name', orderable:false}                            
          ],		  
		  "language": {
			"url": "{{asset('i18n/datatables/Spanish.json')}}"
			}
   });
  }	
  
    $('#btn-filtrado').click(function(){
    $('#table_gastos').DataTable().destroy();
    fill_datatable();
  });
   
	/*
     var table = $('#fissy_table').addClass( 'nowrap' )
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
