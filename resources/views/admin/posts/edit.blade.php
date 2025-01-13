<x-admin-layout>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <form action="{{route('admin.posts.update', $post)}}" method="POST">

        @csrf
        @method('PUT')

        {{-- validaciones de error --}}
        <x-validation-errors class="mb-4"/>

        {{-- Titulo --}}
        <div class="mb-4">
            <x-label class="mb-1">
                Title
            </x-label>
            <x-input class="w-full" name="title" value="{{old('title', $post->title)}}" placeholder="Escriba el titulo del post"/>
        </div>

        {{-- Slug --}}
        <div class="mb-4">
            <x-label class="mb-1">
                slug
            </x-label>
            <x-input class="w-full" name="slug" value="{{old('slug', $post->slug)}}" placeholder="Escriba el titulo del post"/>
        </div>

        {{-- Categoria --}}
        <div class="mb-4">
            <x-label class="mb-1">
                Categoria
            </x-label>
            <select class="w-full post-category" name="category_id">
                <option value="">Seleccione...</option>
                @foreach ($categories as $category)
                    <option @selected(old('category_id', $post->category->id) == $category->id) value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

                
            </select>
        </div>

        {{-- Resumen --}}
        <div class="mb-4">
            <x-label class="mb-1">
                Resumen
            </x-label>
            <x-textarea class="w-full" name="excerpt" rows="5">{{old('excerpt', $post->excerpt)}}</x-textarea>
        </div>

        {{-- Tags --}}
        <div class="mb-4">
            <x-label class="mb-1">
                Tags
            </x-label>
            <select class="tag-multiple w-full" name="tags[]" multiple="multiple">
                {{-- Asi se hace en el caso que los datos no se carguen desde ajax y sean menos --}}
                {{-- @foreach ($tags as $tag)
                    <option 
                        value="{{$tag->id}}"
                        @selected($post->tags->contains($tag->id))
                        @selected(collect(old('tags', $post->tags->pluck('id')))->contains($tag->id))
                    >
                        {{$tag->name}}
                    </option>
                @endforeach --}}

                {{-- En el caso que sean muchos datos, se muestran los que ya se hayan seleccionado anteriormente --}}
                @foreach ($post->tags as $tag)
                    <option value="{{$tag->name}}" selected>
                        {{$tag->name}}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Body --}}
        <div class="mb-4">
            <x-label class="mb-1">
                Detalle del post
            </x-label>
            <x-textarea class="w-full" name="body" rows="20">{{old('body', $post->body)}}</x-textarea>
        </div>

        {{-- Publicar --}}
        <div class="mb-4">
            <input type="hidden" value="0" name="published">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" @checked(old('published', $post->published) == 1) name="published" value="1" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Publicar</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mb-4 flex justify-end border rounded p-2">
            {{-- Regresar al listado --}}
            <x-button type="button" onclick="location.href='{{route('admin.posts.index')}}'" class="mr-2 bg-green-700">
                Regresar al listado
            </x-button>

            {{-- Editar registro --}}
            <x-button>
                Editar registro
            </x-button>

            {{-- Eliminar registro --}}
            <x-button type="button" id="btn-delete-post" class="ml-2 bg-red-700">
                Eliminar registro
            </x-button>
        </div>
    </form>

    {{-- Formulario para eliminar el post --}}
    <form id="form-delete-post" action="{{route('admin.posts.destroy', $post)}}" method="POST">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('.tag-multiple').select2({
                    tags: true,
                    tokenSeparators: [',', ' '],
                    placeholder: 'Tags asociados al post',
                    minimumInputLength: 2,
                    ajax: {
                        url: "{{route('api.tags.index')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params){
                            return {
                                term: params.term
                            }
                        },
                        processResults: function(data){
                            return {
                                results: data
                            }
                        },
                    }
                });
                $('.post-category').select2();
            });
        </script>

        <script>
            let btnDeletePost = document.getElementById('btn-delete-post');
            let formDeletePost = document.getElementById('form-delete-post');

            btnDeletePost.addEventListener('click', function(e){
                e.preventDefault();

                formDeletePost.submit();
            });
        </script>
    @endpush
</x-admin-layout>