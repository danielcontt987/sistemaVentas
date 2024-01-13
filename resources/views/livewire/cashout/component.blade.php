<div class="row sale layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>Corte de caja</b>
                </h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Usuario</label>
                            <select wire:model="userid" class="form-control">
                                <option value="0" selected>Elegir</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('userid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha inicial</label>
                            <input type="date" wire:model.lazy="fromDate" class="form-control">
                            @error('fromDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input type="date" wire:model.lazy="toDate" class="form-control">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        
                       @if ($userid > 0 && $fromDate != null && $toDate != null)
                            <button wire:click.prevent="Consultar" type="button"
                            class="btn btn-dark">Consultar</button>
                       @endif

                       @if ($total > 0)
                            <button wire:click.prevent="Print()" type="button"
                            class="btn btn-dark">Imprimir</button>
                       @endif
                        
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark">
                        <h5 class="text-white">Ventas Totales: ${{number_format($total,2)}}</h5>
                        <h5 class="text-white">Artículos: {{number_format($items)}}</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table striped mt-1">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <td class="table-th text-center text-white">FOLIO</td>
                                    <td class="table-th text-center text-white">TOTAL</td>
                                    <td class="table-th text-center text-white">CANTIDAD</td>
                                    <td class="table-th text-center text-white">FECHA</td>
                                    <td class="table-th text-center text-white"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($total <= 0)
                                    <tr>
                                        <td colspan="4"><h6 class="text-center">No hay ventas en las fechas seleccionadas</h6></td>
                                    </tr>
                                @endif

                                @foreach ($sales as $sale )
                                    <tr>
                                        <td class="text-center"><h6>{{$sale->id}}</h6></td>
                                        <td class="text-center"><h6>${{number_format($sale->total,2)}}</h6></td>
                                        <td class="text-center"><h6>{{$sale->items}}</h6></td>
                                        <td class="text-center"><h6>{{$sale->created_at}}</h6></td>
                                        <td class="text-center">
                                            <button wire:click.prevent="viewDatails({{$sale}})" class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cashout.modalDetails')
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#modal-details').modal('show')
        })
    });
</script>