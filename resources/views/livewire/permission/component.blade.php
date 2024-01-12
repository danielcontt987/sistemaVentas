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
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white">DESCRIPTION</th>
                                <th class="table-th text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $p)
                                <tr>
                                    <td>
                                        <h6>{{ $p->id }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $p->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile"
                                            wire:click="Edit({{ $p->id }})" title="Editar registro">

                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile"
                                            onclick="Confirmar('{{ $p->id }}')" title="Eliminar registro">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
    @include('livewire.permission.form')
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('permission-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg);
        })

        window.livewire.on('permission-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg);
        })

        window.livewire.on('permission-deleted', Msg => {
            noty(Msg);
        })

        window.livewire.on('permission-exists', Msg => {
            noty(Msg);
        })

        window.livewire.on('permission-error', Msg => {
            noty(Msg);
        })

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })

    });

    function Confirmar(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "De eliminar este registro",
            type: "warning",
            showCancelButton: true,
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('destroy', id)
                Swal.fire("Exitoso!", "La categoria ha sido eliminada correctamente", "success");

            }
        })
    }
</script>
