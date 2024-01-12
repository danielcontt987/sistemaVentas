<div class="row sales layout-top-spacing">
    <div class="col-sm"-12>
        <div class="widget widget-chart-one">
            <div class="widget-haeding">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>

            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="role" class="form-control">
                            <option value="Elegir">Seleccione el rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncAll()" type="button"
                        class="btn btn-dark mbmobile inblock mr-5">Seleccionar todos</button>
                    <button onclick="RemoveAll()" type="button" class="btn btn-dark mbmobile inblock mr-5">Revocar
                        todos</button>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-reponsive">
                            <table class="table table-bordered table striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $p)
                                        <tr>
                                            <td class="text-center">
                                                <div class="n-check">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox"
                                                            wire:change="syncPermi($('#p'+{{ $p->id }}).is(':checked'), '{{ $p->name }}')"
                                                            id="p{{ $p->id }}" value="{{ $p->id }}"
                                                            class="new-control-input"
                                                            {{ $p->checked == 1 ? 'checked' : '' }}>
                                                        <span class="new-control-indicator"></span>
                                                        <h6>{{ $p->name }}</h6>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($p->name)->count() }}</h6>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    Include Form
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('permi', Msg => {
            noty(Msg)
        })
        window.livewire.on('sync-all', Msg => {
            noty(Msg)
        })
        window.livewire.on('remove-all', Msg => {
            noty(Msg)
        })
    });

    function RemoveAll(id) {
        swal({
            title: "¿Estás seguro?",
            text: "De eliminar este registro",
            type: "warning",
            showCancelButton: true,
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('remove-all')
                swal.close();
            }
        })
    }
</script>
