<div wire:ignore.self id="modal-details" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-center text-white">
                    <b>Detalle de la venta</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <td class="table-th text-center text-white">PRODUCTO</td>
                                <td class="table-th text-center text-white">CANT.</td>
                                <td class="table-th text-center text-white">PRECIO</td>
                                <td class="table-th text-center text-white">IMPORTE</td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($details as $detail)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $detail->product }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $detail->quantity }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($detail->price, 2) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($detail->price * $detail->quantity, 2) }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <h6 class="text-info">TOTALES:</h6>
                            </td>
                            <td class="text-center">
                                @if ($details)
                                    <h6 class="text-info">{{ $details->sum('quantity') }}</h6>
                                @endif
                                @if ($details)
                                    @php
                                        $myTotal = 0;
                                    @endphp
                                    @foreach ($details as $detail)
                                        @php
                                            $myTotal += $detail->quantity * $detail->price;
                                        @endphp
                                    @endforeach
                                    <td></td>
                                    <td class="text-center"><h6 class="text-info">${{number_format($myTotal, 2)}}</h6></td>
                                @endif
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
