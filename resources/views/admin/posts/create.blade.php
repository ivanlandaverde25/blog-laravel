<x-admin-layout>

    {{-- Titulo --}}
    <h1 class="font-semibold text-3xl mb-2">Registrar nuevo articulo</h1>

    {{-- Formulario de creacion --}}
    <form action="{{route('admin.posts.store')}}" method="POST" x-data="data()" x-init="$watch('title', value => {string_to_slug(value)})">
        @csrf

        {{-- validaciones de error --}}
        <x-validation-errors class="mb-4"/>

        {{-- Nombre --}}
        <div class="mb-4">
            <x-label class="mb-2">
                Titulo del articulo
            </x-label>
            <x-input name="title" value="{{old('title')}}" x-model="title" class="w-full" placeholder="Ingrese el nombre del articulo" required/>
        </div>

        {{-- Categoria --}}
        <div class="mb-4">
            <x-label class="mb-2">
                Categoria
            </x-label>
            <x-select class="post-category w-full" name="category_id">
                <option value="">Seleccione...</option>
                @foreach ($categories as $category)
                    <option @selected(old('category_id') == $category->id) value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </x-select>
        </div>

        {{-- Slug --}}
        <div class="mb-4">
            <x-label class="mb-2">
                Slug del articulo
            </x-label>
            <x-input name="slug" value="{{old('slug')}}" x-model="slug" id="slug" class="w-full" placeholder="Ingrese la url del articulo" required/>
        </div>

        {{-- Accion --}}
        <div class="flex justify-end border p-2 rounded-lg">
            
            <x-button type="button" onclick="location.href='{{route('admin.posts.index')}}'" class="bg-green-700 mr-2">
                Regresar al listado
            </x-button>

            <x-button>
                Crear articulo
            </x-button>

        </div>
    </form>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        {{-- <script>
            $(document).ready(function() {
                $('.post-category').select2();
            });
        </script> --}}
        
        <script>
            function data(){
                return {
                    title: '',
                    slug: '',
                    string_to_slug(str){
                        str = str.replace(/^\s+|\s+$/g, '');
                        str = str.toLowerCase();
                        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                        var to = "aaaaeeeeiiiioooouuuunc------";
                        for (var i = 0, l = from.length; i < l; i++) {
                            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                        }
                        str = str.replace(/[^a-z0-9 -]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                        this.slug = str;
                    }
                }
            }
        </script>
    @endpush
</x-admin-layout>