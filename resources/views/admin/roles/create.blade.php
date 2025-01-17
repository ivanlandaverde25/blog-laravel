<x-admin-layout>
    
    <div class="bg-gray-100 shadow rounded-lg p-6">
        
        <form method="POST" action="{{route('admin.roles.store')}}">
            @csrf

            <x-validation-errors class="my-4"/>

            {{-- Nombre --}}
            <div class="mb-3">
                <x-label class="mb-1">
                    Nombre del rol
                </x-label>
                <x-input 
                    class="w-full" 
                    name="name" 
                    value="{{old('name')}}"
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
                                    :checked="in_array($permission->id, old('permissions', []))" 
                                />
                                {{$permission->name}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3 p-3 rounded-lg flex justify-end bg-white">
                <x-button class="">
                    Crear rol
                </x-button>

                <x-button type="button" class="bg-green-700 ml-3 hover:bg-green-800" onclick="location.href='{{route('admin.roles.index')}}'">
                    Regresar al listado
                </x-button>
            </div>
        </form>
    </div>

</x-admin-layout>