<x-admin-layout>
    
    <div class="bg-gray-100 shadow rounded-lg p-6">
        
        <h1 class="mb-4 text-lg font-bold">
            Editar rol
        </h1>

        <form method="POST" action="{{route('admin.roles.update', $role)}}">
            @csrf
            @method('PUT')

            <x-validation-errors class="my-4"/>

            {{-- Nombre --}}
            <div class="mb-3">
                <x-label class="mb-1">
                    Nombre del rol
                </x-label>
                <x-input 
                    class="w-full" 
                    name="name" 
                    value="{{old('name', $role->name)}}"
                    placeholder="Ingrese el nombre del rol" 
                    minlength="2" 
                    maxlength="255" 
                    required/>
            </div>

            {{-- Permisos --}}
            <div class="mb-3">
                <x-label class="mb-1">
                    Permisos
                </x-label>

                <ul>
                    @foreach ($permissions as $permission)
                        <li>
                            <label>
                                <x-checkbox 
                                    name="permissions[]" 
                                    id="permission" 
                                    value="{{$permission->id}}"
                                    :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))" 
                                />
                                {{$permission->name}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3 p-3 rounded-lg flex justify-end bg-white">
                <x-button class="">
                    Actualizar rol
                </x-button>

                <x-button type="button" class="bg-green-700 ml-3 hover:bg-green-800" onclick="location.href='{{route('admin.roles.index')}}'">
                    Regresar al listado
                </x-button>

                <x-button type="button" class="bg-red-700 ml-3 hover:bg-red-800" id="btnDeleteRol">
                    Eliminar rol
                </x-button>
            </div>
        </form>

        <form method="POST" id="formDeleteRol" action="{{route('admin.roles.destroy', $role)}}">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('js')
    <script>
        let btnDeleteRol = document.getElementById('btnDeleteRol');
        let formDeleteRol = document.getElementById('formDeleteRol');

        btnDeleteRol.addEventListener('click', (e) => {
            e.preventDefault();
            formDeleteRol.submit();
        });

    </script>
    @endpush

</x-admin-layout>