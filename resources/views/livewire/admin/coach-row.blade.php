<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200" >
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        <flux:avatar size="lg" src="https://unavatar.io/x/calebporzio" />
    </th>
    <td class="px-6 py-4 font-medium text-1xl">
        {{ $coach->person->first_name }} {{ $coach->person->last_name }}
    </td>
    <td class="px-6 py-4 font-medium text-1xl">
        {{ $coach->person->phone }}
    </td>
    <td class="px-6 py-4 font-medium text-1xl">
        {{ $coach->person->email }}
    </td>
    <td class="w-40 px-4 py-4 font-medium text-1xl">
        <flux:badge variant="solid" color="{{ $coach->is_active ? 'green' : 'red' }}">
            {{ $coach->is_active ? 'Activo' : 'Desactivado' }}
        </flux:badge>
    </td>
    <td class="px-6 py-4 font-medium text-1xl flex justify-center items-center">
        <flux:button 
            icon="arrow-path-rounded-square"
            type="checkbox"
            wire:click="toggle"
            :checked="$coach->is_active"
            class="cursor-pointer"></flux:button>
    </td>
    <td class="px-6 py-4">
        <div class="flex space-x-2">
            <flux:button variant="primary" as="a" href="{{route('admin.coaches.edit', $coach)}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                Editar
            </flux:button>
            
            <form class="delete-form" action="{{ route('admin.coaches.destroy', $coach) }}" method="POST">
                @csrf
                @method('DELETE')
                <flux:button variant="danger" type="submit" class="cursor-pointer">Eliminar</flux:button>
            </form>
        </div>
    </td>
</tr>
