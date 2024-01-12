<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark mb-3">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }} | {{ $selected_id > 0 ? 'Editar' : 'Crear' }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>Por favor espere</h6>
            </div>
            <div class="model-body mb-5">
                <div class="row">
                    <div class="col-sm-12 mt-10 ml-3 mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                        
                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="permissionName" placeholder="ej: category_index"class="form-control">
                        </div>
                        @error('permissionName') <span class="text-danger er">{{ $message}}</span> @enderror
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" wire:click.prevent="resetUI()"
                        data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>

                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="CreatePermission()"
                            class="btn btn-dark close-modal">Guardar</button>
                    @else
                        <button type ="button" wire:click.prevent="UpdatePermission()" class="btn btn-dark close-modal"><i
                                class="flaticon-cancel-12"></i> Actualizar </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
