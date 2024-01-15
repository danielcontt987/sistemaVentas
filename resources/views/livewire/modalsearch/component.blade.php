<div wire:ignore.self id="modalSearchProduct" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="input-group">
                    <input wire:model="search" type="text" id="modal-search-input" placeholder="Puedes buscar por nombre, categoria, codigo, etc del producto" class="form-control">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp">
                            <i class="fas fa-search" ></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="table-responsive">
                        <table class="table striped mt-1">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th width="4%"></th>
                                    <th class="table-th text-left text-white">DESCRIPCION</th>
                                    <th width="13%" class="table-th text-center text-white">PRECIO</th>
                                    <th class="table-th text-center text-white">CATEGORIA</th>
                                    <th class="table-th text-center text-white">
                                        <button wire:click.prevent="addAll" class="btn btn-info" {{count($products) > 0 ? '' : 'disable'}}>
                                            <i class="fas fa-check"></i>
                                            TODOS
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
    
                                @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <span>
                                            <img src="{{asset('storage/productos/' . $product->img)}}" alt="img" height="50" width="50" class="rounded">
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-left">
                                            <h6><b>{{ $product->name }}</b></h6>
                                            <small class="text-info">{{$product->barcode}}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($product->price, 2) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $product->category }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <button wire:click.prevent="$emit('scan-code-byid', {{$product->id}})" class="btn btn-dark">
                                            <i class="fas fa-cart-arrow-down mr-1"></i>
                                            AGREGAR 
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">SIN RESULTADOS</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
