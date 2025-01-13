<x-admin-layout>
    
    {{-- Formulario de creacion --}}
    <form method="POST" 
        action="{{route('admin.categories.update', $category)}}"
        class="bg-white rounded-lg p-6 shadow-lg mt-2">
        
        @csrf
        @method('PUT')

        {{-- Errores de validacion --}}
        <x-validation-errors class="mb-4"/>

        <div class="mb-4">
            <x-label class="mb-1">Nombre</x-label>
            <x-input name="name" value="{{old('name', $category->name)}}" class="w-full" placeholder="Escriba el nombre de la categoria" required/>
            
        </div>
        
        <div class="flex justify-end">
            
            {{-- Boton para actualizar --}}
            <x-button>
                Actualizar categoria
            </x-button>

            {{-- Boton para eliminar --}}
            <x-danger-button class="ml-3" id="category-delete">
                Eliminar categoria
            </x-danger-button>
        </div>
    </form>

    {{-- Formulario para eliminar el registro --}}
    <form action="{{route('admin.categories.destroy', $category)}}" method="POST" id="form-delete">

        @csrf
        @method('DELETE')
        
    </form>
    @push('js')
        <script>
            let buttonDelete = document.getElementById('category-delete');
            let formDelete = document.getElementById('form-delete');

            buttonDelete.addEventListener('click', function(e) {
                e.preventDefault;

                formDelete.submit();
            });
        </script>
    @endpush

</x-admin-layout>