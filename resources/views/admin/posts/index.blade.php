<x-admin-layout>
    
    {{-- Acciones --}}
    <div class="flex justify-end mb-3 border rounded p-2">
        <button 
            type="button" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            onclick="location.href='{{route('admin.posts.create')}}'"
        >
            Crear nuevo
        </button>
    </div>

    {{-- Listado de posts --}}
    <ul class="space-y-8">
        @foreach ($posts as $post)
            <li class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                {{-- Image --}}
                <div class="">
                    <a href="{{route('admin.posts.edit', $post)}}">
                        <img class="aspect-[16/9] object-cover object-center w-full" loading="lazy" src="{{$post->image}}" alt="">
                    </a>
                </div>
                
                {{-- Titulo del post --}}
                <div class="">
                    <h1 class="text-xl font-semibold">
                        <a href="{{route('admin.posts.edit', $post)}}">
                            {{$post->title}}
                        </a>
                    </h1>

                    <hr class="my-2">

                    <span @class([
                        'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300' => $post->published,
                        'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300' => !$post->published
                    ])>
                        {{$post->published ? "published" : 'Borrador'}}
                    </span>

                    <p class="text-gray-700 mt-2">
                        {{Str::limit($post->excerpt, 100)}}
                    </p>

                    <div class="flex justify-end mt-4">
                        <button 
                            type="button" 
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            onclick="location.href='{{route('admin.posts.edit', $post)}}'"
                            >
                            Editar post
                        </button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Paginacion --}}
    <div class="my-4">
        {{$posts->links()}}
    </div>
</x-admin-layout>