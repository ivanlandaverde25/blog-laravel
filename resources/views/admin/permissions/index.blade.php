<x-admin-layout>
    
    {{-- Acciones --}}
    <div class="flex justify-end mb-3 border rounded p-2">
        <button 
            type="button" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            onclick="location.href='{{route('admin.permissions.create')}}'"
        >
            Crear nuevo
        </button>
    </div>

    @if ($permissions->count())
        
        {{-- Tabla --}}
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$permission->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$permission->name}}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{route('admin.permissions.edit', $permission)}}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="paginate mt-5">
            {{$permissions->links()}}
        </div>

    @else
    
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <span class="font-medium">Informacion</span> No se han creado permisos en esta tabla.
        </div>

    @endif


</x-admin-layout>