<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class  RolesController  extends Component
{
    use WithPagination;

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    // public function paginationView()
    // {
    //     return 'vendor.livewire.boostrap';
    // }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }
    public function render()
    {
        if(strlen($this->search) > 0)
            $roles = Role::where('name', 'like', '%'. $this->search.'%')->paginate($this->pagination);
        else
            $roles = Role::orderBy('name', 'desc')->paginate($this->pagination);

        return view('livewire.roles.component', [
            'roles' => $roles,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreateRole()
    {
        $rules = ['roleName' => 'required|min:2|unique:roles,name'];
        $message = [
            'roleName.required' => "El nombre del role es requerido",
            'roleName.unique' => "El rol ya existe",
            'roleName.name' => "El nombre del role debe de tener al menos 2 carateres",

        ];

        $this->validate($rules, $message);

        Role::create([
            'name' => $this->roleName,
        ]);

        $this->emit('role-added', 'Se registró el rol con éxito');
        $this->resetUI();
    }

    public function Edit($id)
    {
        $role = Role::find($id);
        $this->selected_id = $role->id;
        $this->roleName = $role->name;
        $this->emit('show-modal', 'Show modal');
    }

    public function UpdateRole()
    {
        $rules = ['roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"];
        $message = [
            'roleName.required' => "El nombre del role es requerido",
            'roleName.unique' => "El rol ya existe",
            'roleName.name' => "El nombre del role debe de tener al menos 2 carateres",

        ];

        $this->validate($rules, $message);
        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Se actualizó el rol con éxito');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $premissionsCount = Role::find($id)->permissions->count();
        if ($premissionsCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el rol proque tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();
        $this->emit('role-deleted', 'Se eliminó el role con éxito');

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
        $this->roleName = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetErrorBag();
    }
}
