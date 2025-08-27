<div>
    
    <div class="mb-4 p-2 flex justify-center items-center space-x-4">
        <flux:input 
            wire:model.live.debounce.500ms="name" 
            class="w-100" 
            icon="magnifying-glass"  
            placeholder="Filtrar por Nombre"
        />

        <flux:select wire:model.live="is_active" placeholder="Filtrar por Estado">
            <flux:select.option value="">Todos los estados</flux:select.option>
            <flux:select.option value="1">Activo</flux:select.option>
            <flux:select.option value="0">Baja</flux:select.option>
        </flux:select>
    </div>

    <div class="relative overflow-x-auto">
        <div class="mt-4 mb-4">
            {{ $suppliers->links()}}
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-800 uppercase bg-lime-500 dark:bg-lime-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Cambiar Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-center" width="10px">
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-1xl text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $supplier->id}}
                        </th>
                        <td class="px-6 py-4 font-medium text-1xl">
                            {{ $supplier->name }}
                        </td>
                        <td class="w-40 px-4 py-4 font-medium text-1xl">
                            <flux:badge variant="solid" color="{{ $supplier->is_active ? 'green' : 'red' }}">
                                {{ $supplier->is_active ? 'Activo' : 'Desactivado' }}
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4 font-medium text-1xl flex justify-center items-center">
                            <flux:button 
                                icon="arrow-path-rounded-square"
                                type="checkbox"
                                wire:click="toggle({{ $supplier->id }})"
                                :checked="$supplier->is_active"
                                class="cursor-pointer">
                            </flux:button>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                    <flux:button variant="primary" color="blue" as="a" href="{{ route('admin.suppliers.edit', $supplier) }}">
                                        Editar
                                    </flux:button>
                                <div></div>
                                <form class="delete-form" action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button variant="danger" class="cursor-pointer" type="submit">Eliminar</flux:button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>

</div>
