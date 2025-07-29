<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
    <th scope="row" class="px-6 py-4 font-medium text-1xl text-gray-900 whitespace-nowrap dark:text-white">
        {{ $product_type->id }}
    </th>
    <td class="px-6 py-4 font-medium text-1xl">
        {{ $product_type->name }}
    </td>
    <td class="w-40 px-4 py-4 font-medium text-1xl">
        <flux:badge variant="solid" color="{{ $product_type->is_active ? 'green' : 'red' }}">
            {{ $product_type->is_active ? 'Activo' : 'Desactivado' }}
        </flux:badge>
    </td>
    <td class="px-6 py-4 font-medium text-1xl flex justify-center items-center">
        <flux:button 
            icon="arrow-path-rounded-square"
            type="checkbox"
            wire:click="toggle"
            :checked="$product_type->is_active"
            class="cursor-pointer"></flux:button>
    </td>
    <td class="px-6 py-4">
        <div class="flex space-x-2">
            <flux:button variant="primary" color="blue" as="a" href="{{ route('admin.product_types.edit', $product_type) }}">
                Editar
            </flux:button>
            <form class="delete-form" action="{{ route('admin.product_types.destroy', $product_type) }}" method="POST">
                @csrf
                @method('DELETE')
                <flux:button variant="danger" class="cursor-pointer" type="submit">Eliminar</flux:button>
            </form>
        </div>
    </td>
</tr>
