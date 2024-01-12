@include('common.modalHead')
<div class="row m-auto">
    <div class="col-sm-12 col-md-8">
        <label>Nombre</label>
        <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej. José Daniel">
        @error('name')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-4">
        <label>Teléfono</label>
        <input type="text" wire:model.lazy="phone" class="form-control" maxlength="10" placeholder="ej. 311-123-09-09">
        @error('phone')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Email</label>
        <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej. ejemplo.com">
        @error('email')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Contraseña</label>
        <input type="text" wire:model.lazy="password" class="form-control" placeholder="ej. ejemplo.com">
        @error('password')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Estatus</label>
        <select wire:model.lazy="status" class="form-control">
            <option value="Elegir" selected>Elegir</option>
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO" selected>Bloqueado</option>
        </select>
        @error('status')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Asignar rol</label>
        <select wire:model.lazy="profile" class="form-control">
            <option value="Elegir" selected>Elegir</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
        @error('profile')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12">
        <label>Imagen de perfil</label>
        <input type="file" wire:model="image" accept="image/x-png, image/jpeg, image/gif" class="form-control"
            placeholder="ej. ejemplo.com">
        @error('image')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
</div>

@include('common.modalFooter')
