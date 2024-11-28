<div class="col-md-12 mb-5">
    <form action="{{route('referido_fissy')}}" method="post" name="form_add_codigo_referido" id="form_add_codigo_referido">
        @csrf
        <div class="offset-md-3 col-md-6">
            <div class="card card-body">
                <div class="form-group">
                    <label for="pedir_referido">Ingresar codigo de Referido</label>
                </div>
                <div class="input-group input-group-sm mb-3 col-md-12">
                    <input type="text" name="pedir_referido" id="pedir_referido" value="" class="form-control form-control-sm" required>
                    <div class="input-group-append">
                      <button class="input-group-text bg-fissy text-white"><i class="fa fa-send-o"></i></button>
                    </div>
                </div>
                <div class="offset-md-4 col-md-4">
                    <div class="mt-2">
                        <button class="btn btn-sm bg-fissy text-light" type="submit" title="agregar contactos">Enviar <i class="fa fa-send"></i></button>
                    </div>
                </div>                            
            </div>      
        </div>

    </form>
    </div>