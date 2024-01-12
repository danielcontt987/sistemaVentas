<div class="row sales layout-top-spacing">
    <div class="col-sm"-12>
        <div class="widget widget-chart-one">
            <div class="widget-haeding">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li style="list-style:none" class="d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-dark tbmenu" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-reponsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white text-center">TELÉFONO</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">PERFIL</th>
                                <th class="table-th text-white text-center">ESTATUS</th>
                                <th class="table-th text-white text-center">IMÁGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <h6>{{ $user->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $user->phone }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $user->email }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $user->profile }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $user->status == 'ACTIVO' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $user->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->image != null)
                                            <span>
                                                <img src="{{ asset('storage/users/' . $user->image) }}"
                                                    alt="imagen de ejemplo" height="70" width="80"
                                                >
                                            </span>
                                            @else
                                            <span>
                                            
                                                <img src="{{ asset('assets/img/no-image.png') }}"
                                                    alt="imagen de ejemplo" height="70" width="80"
                                                >
                                            </span>
                                            
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="edit({{ $user->id }})"
                                            class="btn btn-dark mtmobile" title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $user->id }}')"
                                            class="btn btn-dark mtmobile" title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.user.form')
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('user-added', msg => {
            $('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
        })

        window.livewire.on('user-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg);
        })

        window.livewire.on('user-deleted', msg => {
            noty(msg);
        })

        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('user-withsale', msg => {
            noty(msg);
        })
    });

    function Confirm(id) {
            Swal.fire({
                title: "CONFIRMAR",
                text: "¿CONFIRMAS ELIMINAR EL REGISTRO?",
                type: "warning",
                showCancelButton: true,
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('deleteRow', id);
                    Swal.fire("Exitoso!", "La categoria ha sido eliminada correctamente", "success");

                }
            })
        }
</script>
