<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class  PermisosController  extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    // public function paginationView()
    // {
    //     return 'vendor.livewire.boostrap';
    // }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }
    public function render()
    {
        if(strlen($this->search) > 0)
            $permissions = Permission::where('name', 'like', '%'. $this->search.'%')->paginate($this->pagination);
        else
            $permissions = Permission::orderBy('name', 'desc')->paginate($this->pagination);

        return view('livewire.permission.component', [
            'permissions' => $permissions,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];
        $message = [
            'permissionName.required' => "El nombre del permiso es requerido",
            'permissionName.unique' => "El permiso ya existe",
            'permissionName.name' => "El nombre del permiso debe de tener al menos 2 carateres",

        ];

        $this->validate($rules, $message);

        Permission::create([
            'name' => $this->permissionName,
        ]);

        $this->emit('permission-added', 'Se registró el permiso con éxito');
        $this->resetUI();
    }

    public function Edit($id)
    {
        $permission = Permission::find($id);
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;
        $this->emit('show-modal', 'Show modal');
    }

    public function UpdateRole()
    {
        $rules = ['permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"];
        $message = [
            'permissionName.required' => "El nombre del permiso es requerido",
            'permissionName.unique' => "El permiso ya existe",
            'permissionName.name' => "El nombre del permiso debe de tener al menos 2 carateres",

        ];

        $this->validate($rules, $message);
        $permission = Permission::find($this->selected_id);
        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('role-updated', 'Se actualizó el permiso con éxito');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if ($rolesCount > 0) {
            $this->emit('permission-error', 'No se puede eliminar el rol proque tiene permisos asociados');
            return;
        }

        Permission::find($id)->delete();
        $this->emit('permission-deleted', 'Se eliminó el permiso con éxito');

    }

    public function AsignRoles($roleList){
        if($this->userSelected > 0)
        {
            $user = User::find($this->userSelected);
            if ($user) {
                $user->syncRoles($roleList);
                $this->emit('msg-ok', 'Roles asignados correctamente');
                $this->resetUI();
            }
        }
    }

    public function resetUI()
    {
        $this->permissionName = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetErrorBag();
    }
}
