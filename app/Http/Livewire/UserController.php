<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserController extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $file_loaded, $profile;
    public $pageTitle, $componentName, $search;
    private $pagination = 3;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Usuarios";
        $this->status = "Elegir";
    }


    public function render()
    {
        if (strlen($this->search) > 0)
            $users = User::where('name', 'like', '%' . $this->name . '%')
                ->select('*')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);
        else
            $users = User::select('*')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);

        return view('livewire.user.component', [
            'users' => $users,
            'roles' => Role::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function resetUI()
    {
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->phone = "";
        $this->image = "";
        $this->search = "";
        $this->status = "Elegir";
        $this->selected_id = 0;
        $this->resetValidation();
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = "";
        $this->emit('show-modal', 'open');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy',
        'resetUI' => 'resetUI',
    ];

    public function Store()
    {
        $rules =  [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:8',
        ];

        $messages = [
            'name.required' => 'Favor de ingresar el nombre',
            'name.min' => 'El nombre debe de tener al menos 3 caracteres',
            'email.required' => 'Favor de ingresar el email',
            'email.email' => 'Favor de ingresar un email válido',
            'email.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Favor de seleccionar un estatus',
            'status.not_in' => 'Favor de seleccionar diferente a elegir',
            'profile.required' => 'Favor de seleccionar un perfil',
            'profile.not_in' => 'Favor de seleccionar diferente a elegir',
            'password.required' => 'Favor de ingresar la contraseña',
            'password.min' => 'La contraseña debe de tener al menos 8 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users/', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado');
    }

    public function Update()
    {
        $rules =  [
            'name' => 'required|min:3',
            'email' => "required|email|unique:users,email, {$this->selected_id}",
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:8',
        ];

        $messages = [
            'name.required' => 'Favor de ingresar el nombre',
            'name.min' => 'El nombre debe de tener al menos 3 caracteres',
            'email.required' => 'Favor de ingresar el email',
            'email.email' => 'Favor de ingresar un email válido',
            'email.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Favor de seleccionar un estatus',
            'status.not_in' => 'Favor de seleccionar diferente a elegir',
            'profile.required' => 'Favor de seleccionar un perfil',
            'profile.not_in' => 'Favor de seleccionar diferente a elegir',
            'password.min' => 'La contraseña debe de tener al menos 8 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);

        if($this->image){

            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users/', $customFileName);
            $imageTemp = $user->image;

            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/users/'.$imageTemp)) {
                    unlink('storage/users/'.$imageTemp);
                }
            }

        }

        $this->resetUI();
        $this->emit('user-updated', 'Usuario actualizado');
    }

    public function Destroy(User $user)
    {
        if ($user) {
            $sale = Sale::where('user_id', $user->id)->count();
            if ($sale > 0) {
                $this->emit('user-withsale', 'No es posible eliminar el usuario proque tiene ventas registradas'); 
            }else{
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Usuario eliminado');
            }
        }
    }
}
