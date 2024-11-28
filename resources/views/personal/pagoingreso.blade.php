@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{ route('gastos_import')}}" method="post" enctype="multipart/form-data">
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Pagos e Ingresos</p>
    </nav>
    <div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @csrf
                    <div class="pd-2d">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12  vh-100">
                                        <h6>Mis ingresos por Fi$$y</h6>
                                        <div class="table-responsive border" style="min-height:500px">
                                            <table class="table table-bordered table-hover" id="mispagos">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Monto</th>
                                                        <th>Fi$$y No.</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
            
                                                </tbody>
                                                <tfoot>
            
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 vh-100 ">
										<h6>Mis pagos por Fi$$y</h6>
                                        <div class="table-responsive border" style="min-height:500px" >
                                            <table class="table table-bordered table-hover" id="misingresos">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Monto</th>
                                                        <th>Fi$$y No.</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
            
                                                </tbody>
                                                <tfoot>
            
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                             </div>

                            </div>
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
       
       fill_datatable();
       fill_datatable2();
       
     function fill_datatable()
     {
      var dataTable = $('#mispagos').DataTable({
       "processing" : true,
       "serverSide" : true,
       "searching" : false,
       "responsive": true,
       "ajax" : {
        url:"{{route('fissy_mispagos')}}",
        type:"GET",
        data:{
         //monto_min:monto_min, monto_max:monto_max
        }
       },
             "columns":[
                 { data: 'fecha_inicio',
                   name:'fecha_inicio',
                   orderable:false,
                   searchable:false  
                 },
                 { data: 'monto',
                   name: 'monto', 
                   className: 'text-right',
                   render: function (data, type, row) {
                      return '$'+row.monto;
   
                   }
                 },
                 { data: 'id', name: 'id', "sClass": "text-center"  },
                 { data: 'estado', name:'estado', "sClass": "text-center" }
             ],
             "language": {
               "url": "{{asset('i18n/datatables/Spanish.json')}}"
               }
      });
     }

     function fill_datatable2()
     {
      var dataTable = $('#misingresos').DataTable({
       "processing" : true,
       "serverSide" : true,
       "searching" : false,
       "responsive": true,
       "ajax" : {
        url:"{{route('fissy_misingresos')}}",
        type:"GET",
        data:{
         //monto_min:monto_min, monto_max:monto_max
        }
       },
             "columns":[
                 { data: 'fecha_inicio',
                   name:'fecha_inicio',
                   orderable:false,
                   searchable:false  
                 },
                 { data: 'monto',
                   name: 'monto', 
                   className: 'text-right',
                   render: function (data, type, row) {
                      return '$'+row.monto;
   
                   }
                 },
                 { data: 'id', name: 'id', "sClass": "text-center"  },
                 { data: 'estado', name:'estado', "sClass": "text-center" }
             ],
             "language": {
               "url": "{{asset('i18n/datatables/Spanish.json')}}"
               }
      });
     }	
     
       $('#btn-filtrado').click(function(){
       $('#mispagos').DataTable().destroy();
       fill_datatable();
     });


         $('.has-calendar').datepicker({
             showOtherMonths: true,
             format: 'yyyy-mm-dd'
             //uiLibrary: 'bootstrap4'
         }); 
         
     });
   
   </script>
   
@endsection
