<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de la venta # {{ $saleId }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>Por favor espere</h6>
            </div>
            <div class="model-body mt-2 ml-2 mr-2">
                <div class="table-reponsive">
                    <table class="table table striped mt-1">
                        <thead style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-center text-white">FOLIO</th>
                                <th class="table-th text-center text-white">PRODUCTO</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th class="table-th text-center text-white">CANT</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                            <tr>
                                <td class="text-center">
                                    <h6>{{$d->id}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$d->product}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>${{number_format($d->price,2)}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>${{number_format($d->quantity,0)}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>${{number_format($d->quantity * $d->price,2)}}</h6>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3"><h5 class="text-center font-weight-bold">TOTALES</h5></td>
                            <td ><h5 class="text-center">{{$countDetails}}</h5></td>
                            <td ><h5 class="text-center text-success font-weight-bold">${{number_format($sumDetails,2)}}</h5></td>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                    Cerrar</button>
            </div>
        </div>
    </div>
</div>
