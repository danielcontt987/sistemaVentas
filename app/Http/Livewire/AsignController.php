<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class AsignController extends Component
{
    use WithPagination;

    public $role, $componentName, $permissionSelected = [], $old_permissions = [];
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->role = "Elegir";
        $this->componentName = "Asignar Permiso";
    }

    public function render()
    {
        $permissions = Permission::select('name', 'id', DB::raw("0 as checked"))
        ->orderBy('name', 'asc')
        ->paginate($this->pagination);

        if ($this->role != "Elegir")
        {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
            ->where('role_id', $this->role)->pluck('permissions.id')->toArray();

            $this->old_permissions = $list;
        } 

        if ($this->role != "Elegir") {
            foreach ($permissions as $p) {
                $role = Role::find($this->role);
                $hasPermission = $role->hasPermissionTo($p->name);

                if ($hasPermission) {
                    $p->checked = 1;
                }
            }
        }
        return view('livewire.asign.component',[
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permissions' => $permissions
        ])->extends('layouts.theme.app')
        ->section('content');
    }

    public $listeners = ['remove-all' => 'RemoveAll'];

    public function RemoveAll() 
    {
        if ($this->role != "Elegir") {
            $this->emit('sync-error', "Selecciona un rol valido");
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('remove-all', "Se removieron todos los permisos al $role->name");
    }

    public function SyncAll() 
    {
        if ($this->role != "Elegir") {
            $this->emit('sync-error', "Selecciona un rol valido");
            return;
        }

        $role = Role::find($this->role);
        $permissions = Permission::pluck('id')->toArray();
        if ($role != null) {
            $role->syncPermissions($permissions);
            $this->emit('sync-all', "Se seleccionaron todos los permisos al $role->name");
        }else{
            $this->emit('permi', "Elige un rol valido");
        }
        
    }

    public function syncPermi($state, $permissionName) 
    {
        if ($this->role != "Elegir") {
           $roleName = Role::find($this->role);
           if ($state) {
                $roleName->givePermissionTo($permissionName);
                $this->emit('permi', "Permiso asignado correctamente");
           }else{
                $roleName->revokePermissionTo($permissionName);
                $this->emit('permi', "Permiso eliminado correctamente");
           }
        }else{
            $this->emit('permi', "Elige un rol valido");
        }

    }
}