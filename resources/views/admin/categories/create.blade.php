<x-admin-layout>

    {{-- Formulario de creacion --}}
    <form method="POST" 
        action="{{route('admin.categories.store')}}"
        class="bg-white rounded-lg p-6 shadow-lg mt-2">
        
        @csrf

        {{-- Errores de validacion --}}
        <x-validation-errors class="mb-4"/>

        <div class="mb-4">
            <x-label class="mb-1">Nombre</x-label>
            <x-input name="name" value="{{old('name')}}" class="w-full" placeholder="Escriba el nombre de la categoria" required/>
            
        </div>
        
        <div class="flex justify-end">
            <x-button>
                Crear categoria
            </x-button>
        </div>
    </form>

</x-admin-layout>