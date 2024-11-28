<div class="container">
    <div class="row">
        <div class="col-md-4">
            <a class="navbar-brand text-light" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="logo" width="80">
            </a>
        </div>
        <div class="col-md-8" style="font-size:0.9em">
            <b>Tipo de pago</b></br>
            <b>{{ $fissy->tipo_pago_des }}</b>
        </div>
    </div>        
   
</div>

<div class="container-fluids vh-100">
    <!--
    <nav class="navbar navbar-light bg-fissy py-2 mb-4">
        <p class="text-white font-weight-bold">Crea una oportunidad fff</p>
    </nav>-->
    <div class="container-fluid mt-3">
        <div class="">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Fecha Inicio</div>
                    <div class="bg-secondary text-white text-center font9">&nbsp; {{ $fecha_inicio }} </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Monto</div>
                    <div class="bg-secondary text-white text-center font9">${{ number_format($fissy->monto, 2, ',', '.') }}</div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Plazo Meses</div>
                    <div class="bg-secondary text-white text-center font9">{{ $fissy->periodo }}</div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Interés</div>
                    <div class="bg-secondary text-white text-center font9">{{ $fissy->interes }}</div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Pago Mensual (COP)</div>
                    <div class="bg-secondary text-white text-center font9">${{ number_format($pago_mensual, 2, ',', '.') }}</div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="form-group">
                    <div class="bg-dark text-white text-center font9">Pago Final (COP)</div>
                    <div class="bg-secondary text-white text-center font9">${{  number_format($pago_final, 2, ',', '.') }}</div>
                  </div>
                </div>
            </div>

            <div class="table-responsive">           
                <table class="table table-bordered table-sm table-hover mb-5" style="font-size:0.9em">
                    <thead>
                        <tr class="bg-fissy text-white text-center">
                            <th>Año</th>
                            <th>Mes</th>
                            <th>Cuota</th>
                            <th>Saldo Inicial</th>
                            <th>Capital</th>
                            <th>Interés</th>
                            <th>Valor Pagado</th>
                            <th>Saldo Final</th>
                        </tr>
                    </thead> 
                    <tbody>
                        @if($fissy->tipo_pago == 4)
                            @foreach($plan_pago as $item)
                            <tr>
                                <td align="center">{{ $item['anio'] }}</td>
                                <td align="center">{{ $item['mes'] }}</td>
                                <td align="center">{{ $item['cuota'] }}</td>
                                <td align="right">${{ $item['saldo_inicial'] }}</td>
                                <td align="right">${{ $item['capital'] }}</td>
                                <td align="right">${{ $item['interes']}}</td>
                                <td align="right">${{ $item['valor_pagado'] }}</td>
                                <td align="right">${{ $item['saldo_final'] }}</td>
                            </tr>
                            @endforeach
                        @endif
                        @if($fissy->tipo_pago == 5)
                            @foreach($plan_pago as $item)
                            <tr>
                                <td align="center">{{ $item['anio'] }}</td>
                                <td align="center">{{ $item['mes'] }}</td>
                                <td align="center">{{ $item['cuota'] }}</td>
                                <td align="right">${{ number_format($item['saldo_inicial'], 2, ',', '.') }}</td>
                                @if(count($plan_pago) == $loop->index+1)
                                <td align="right"> ${{ number_format($fissy->fullmonto -$pago_mensual, 2, ',', '.') }}</td>
                                @else
                                <td align="right">${{ $pago_mensual - $pago_mensual }} </td>
                                @endif	
                                <td align="right">${{ number_format($pago_mensual, 2, ',', '.') }}</td>							
                                @if(count($plan_pago) == $loop->index+1)
                                <td align="right"> ${{ number_format($fissy->fullmonto, 2, ',', '.') }}</td>
                                @else
                                <td align="right">${{ number_format($pago_mensual, 2, ',', '.') }} </td>
                                @endif									
                                @if(count($plan_pago) == $loop->index+1)
                                <td align="right"> ${{ 0 }}</td>
                                @else
                                <td align="right">${{  number_format($item['saldo_inicial'] + $pago_mensual - $pago_mensual, 2, ',', '.') }} </td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                        @if($fissy->tipo_pago == 6)
                            @foreach($plan_pago as $item)
								
                                <tr>
                                    <td align="center">{{ $item['anio'] }}</td>
                                    <td align="center">{{ $item['mes'] }}</td>
                                    <td align="center">{{ $item['cuota'] }}</td>
                                    <td align="right">${{ number_format($item['saldo_inicial'] , 0, ',', '.')}}</td>
                                    <td align="right">${{ number_format($item['capital'] , 0, ',', '.') }}</td>
                                    <td align="right">${{ number_format($item['interes'] ,  0, ',', '.')}}</td>
                                    <td align="right">${{ number_format(round($pago_mensual,0), 0, ',', '.') }}</td>
                                    <td align="right">${{ number_format($item['saldo_final'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="8"  align="center">
                                @if((Auth::user()->id  !=  $fissy->usuario_id && $fissy->estado == 7) && $fissy->persona_aplica != Auth::user()->id )
                            <button type="button" class="btn btn-sm bg-fissy text-white" id="btn_aplicar_fissy" data-id="{{ $fissy->id }}" data-url="{{ route('fissy_aplicar', $fissy->id) }}">Aplicar</button>
                                @endif
                            </td>
                        </tr>
                    </tbody>  
                </table> 
            </div> 
        </div>
    </div>
</div>

