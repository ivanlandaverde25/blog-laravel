<x-admin-layout>
    
    <div class="bg-gray-100 shadow rounded-lg p-6">
        
        <h1 class="mb-4 text-lg font-bold">
            Editar Permiso
        </h1>

        <form method="POST" action="{{route('admin.permissions.update', $permission)}}">
            @csrf
            @method('PUT')

            <x-validation-errors class="my-4"/>

            <x-label class="mb-1">
                Nombre del permiso
            </x-label>
            <x-input 
                class="w-full" 
                name="name" 
                value="{{old('name', $permission->name)}}"
                placeholder="Ingrese el nombre del permiso" 
                minlength="2" 
                maxlength="255" 
                required/>

            <div class="mt-3 p-3 rounded-lg flex justify-end bg-white">
                <x-button class="">
                    Actualizar permiso
                </x-button>

                <x-button type="button" class="bg-green-700 ml-3 hover:bg-green-800" onclick="location.href='{{route('admin.permissions.index')}}'">
                    Regresar al listado
                </x-button>

                <x-button type="button" class="bg-red-700 ml-3 hover:bg-red-800" id="btnDeletePermission">
                    Eliminar permiso
                </x-button>
            </div>
        </form>

        <form method="POST" id="formDeletePermission" action="{{route('admin.permissions.destroy', $permission)}}">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('js')
    <script>
        let btnDeletePermission = document.getElementById('btnDeletePermission');
        let formDeletePermission = document.getElementById('formDeletePermission');

        btnDeletePermission.addEventListener('click', (e) => {
            e.preventDefault();
            formDeletePermission.submit();
        });

    </script>
    @endpush

</x-admin-layout>