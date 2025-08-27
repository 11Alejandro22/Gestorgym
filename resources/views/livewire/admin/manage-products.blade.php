<div>
    <div class="mb-4 p-2 flex justify-center items-center space-x-4">
        <flux:input 
            wire:model.live.debounce.500ms="first_name" 
            class="w-100" 
            icon="magnifying-glass"  
            placeholder="Filtrar por Nombre"
        />

        <flux:select wire:model.live="brand_id_select" placeholder="Filtrar por Marca">
            <flux:select.option value="">Todas las marcas</flux:select.option>
            @foreach ($brands as $brand)
                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="product_type_id_select" placeholder="Filtrar por Tipo de Producto">
            <flux:select.option value="">Todos los tipos</flux:select.option>
            @foreach ($product_types as $product_type)
                <flux:select.option value="{{ $product_type->id }}">{{ $product_type->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="is_active" placeholder="Filtrar por Estado">
            <flux:select.option value="">Todos los estados</flux:select.option>
            <flux:select.option value="1">Activo</flux:select.option>
            <flux:select.option value="0">Baja</flux:select.option>
        </flux:select>
    </div>

    <div class="relative overflow-x-auto">
        <div class="mt-4 mb-4">
            {{ $products->links()}}
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-800 uppercase bg-lime-500 dark:bg-lime-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Marca
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipo de Producto
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
                @foreach ($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-1xl text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->name}}
                        </th>
                        <td class="px-6 py-4 font-medium text-1xl">
                            {{ $product->brand->name }}
                        </td>
                        <td class="px-6 py-4 font-medium text-1xl">
                            {{ $product->productType->name }}
                        </td>
                        <td class="w-40 px-4 py-4 font-medium text-1xl">
                            <flux:badge variant="solid" color="{{ $product->is_active ? 'green' : 'red' }}">
                                {{ $product->is_active ? 'Activo' : 'Desactivado' }}
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4 font-medium text-1xl flex justify-center items-center">
                            <flux:button 
                                icon="arrow-path-rounded-square"
                                type="checkbox"
                                wire:click="toggle({{ $product->id }})"
                                :checked="$product->is_active"
                                class="cursor-pointer">
                            </flux:button>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <flux:modal.trigger name="edit_product">
                                    <flux:button variant="primary" color="blue" as="a" href="{{ route('admin.products.edit', $product)}}">
                                        Editar
                                    </flux:button>
                                </flux:modal.trigger>
                                <div></div>
                                <form class="delete-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
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
