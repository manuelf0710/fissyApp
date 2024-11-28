@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{ route('gastos_import')}}" method="post" enctype="multipart/form-data">
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Gastos</p>
    </nav>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-12">                 
                    <h5>Cargar Documento</h5>
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fieldexcel">Archivo Excel</label>
                                <input type="file" name="archivo" class="form-control-file" id="archivo" required>
                                <button class="btn btn-sm bg-fissy text-white mt-2" id="btnuploadfile">Subir Archivo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>
</form>
@endsection
