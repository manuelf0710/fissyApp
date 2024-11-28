@extends('layouts.app')

@section('content')
<!--<nav class="navbar navbar-light bg-fissy py-2 mb-4">
    <p class="text-white font-weight-bold">Bienvenido a tu tablero </p>
</nav>-->
<form action="{{route('fissy_store')}}" method="post" name="form_fissy" id="form_fissy">
<div class="container-fluids vh-100">
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Lista de Fissy aplicados</p>
    </nav>
</form>
@endsection
