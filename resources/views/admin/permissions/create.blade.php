<x-admin-layout>
    
    <div class="bg-gray-100 shadow rounded-lg p-6">
        
        <form method="POST" action="{{route('admin.permissions.store')}}">
            @csrf

            <x-validation-errors class="my-4"/>

            <x-label class="mb-1">
                Nombre del permiso
            </x-label>
            <x-input 
                class="w-full" 
                name="name" 
                value="{{old('name')}}"
                placeholder="Ingrese el nombre del permiso" 
                minlength="2" 
                maxlength="255" 
                required/>

            <div class="mt-3 p-3 rounded-lg flex justify-end bg-white">
                <x-button class="">
                    Crear permiso
                </x-button>

                <x-button type="button" class="bg-green-700 ml-3 hover:bg-green-800" onclick="location.href='{{route('admin.permissions.index')}}'">
                    Regresar al listado
                </x-button>
            </div>
        </form>
    </div>

</x-admin-layout>