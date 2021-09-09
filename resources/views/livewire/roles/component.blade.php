<div class="row sales layout-top-spacing">
    <div class="col-sm"-12>
        <div class="widget widget-chart-one">
            <div class="widget-haeding">
                <h4 class="card-title">
                    <b>{{$componetName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bgdark" data-toggle="modal" data-target="#themodal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-reponsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="color: #F96445">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white">DESCRIPTION</th>
                                <th class="table-th text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $rol)
                            <tr>
                                <td><h6>{{$rol->id}}</h6></td>
                                <td class="text-center">
                                    <h6>{{$rol->name}}</h6>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                       class="btn btn-dark mtmobile" 
                                       wire:click="Edit({{$rol->id}})"
                                       title="Editar registro">

                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" 
                                       class="btn btn-dark mtmobile" 
                                       onclick="Confirmar('{{$rol->id}}')" 
                                       title="Eliminar registro">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    </div>
  @inclide('livewire.roles.form');
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('role-added', Msg=>{
           $('#theModal').modal('hide')
           noty(Msg);
        })

        window.livewire.on('role-updated', Msg=>{
           $('#theModal').modal('hide')
           noty(Msg);
        })

        window.livewire.on('role-deleted', Msg=>{
           noty(Msg);
        })

        window.livewire.on('role-exists', Msg=>{
           noty(Msg);
        })

        window.livewire.on('role-error', Msg=>{
           noty(Msg);
        })

        window.livewire.on('hide-modal', Msg=>{
           $('#theModal').modal('hide')
           noty(Msg);
        })

        window.livewire.on('show-modal', Msg=>{
           $('#theModal').modal('show')
           noty(Msg);
        })

    });
</script>