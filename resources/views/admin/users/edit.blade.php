<x-admin-layout>
    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{route('admin.users.update', $user)}}" method="POST">

            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input placeholder="Nombre de usuario" name="name" value="{{old('name', $user->name)}}" class="w-full" required/>
            </div>
            
            {{-- Email --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input type="email" placeholder="Correo" name="email" value="{{old('email', $user->email)}}" class="w-full" required/>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Contraseña
                </x-label>
                <x-input type="password" placeholder="Contraseña" name="password" class="w-full"/>
            </div>
            
            {{-- Password Confirmation --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Confirmar contraseña
                </x-label>
                <x-input type="password" placeholder="Contraseña" name="password_confirmation" class="w-full"/>
            </div>

            {{-- Roles --}}
            <div class="mb-4">
                <ul>
                    @foreach ($roles as $rol)
                        <li>
                            <label>
                                <x-checkbox 
                                    name="roles[]" 
                                    id="permission" 
                                    value="{{$rol->id}}"
                                    :checked="in_array($rol->id, old('roles', $user->roles->pluck('id')->toArray()))" 
                                />
                                {{$rol->name}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4 p-3 bg-gray-200 rounded-lg flex justify-end">
                <x-button>
                    Actualizar registro
                </x-button>
            </div>

        </form>

        
    </div>
</x-admin-layout>