<div>
    <fieldset >
        <legend class="ml-2"><flux:heading size="lg">Filtros</flux:heading></legend>
        <div class="mb-4 p-2 flex justify-center items-center space-x-4">
            
            <flux:select wire:model.live="supplier_id" placeholder="Filtrar por Marca">
                <flux:select.option value="">Todas las Marcas</flux:select.option>
                @foreach ($suppliers as $supplier)
                <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                @endforeach
            </flux:select>
            
            <flux:input wire:model.live="purchase_date" type="date" max="2999-12-31"/>

        </div>
    </fieldset>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-800 uppercase bg-lime-500 dark:bg-lime-700 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de Compra
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Proveedor
                    </th>
                    <th scope="col" class="px-6 py-3 text-center" width="10px">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-1xl text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $purchase->id}}
                        </th>
                        <td class="px-6 py-4 font-medium text-1xl">
                            {{ $purchase->purchase_date }}
                        </td>
                        <td class="px-6 py-4 font-medium text-1xl">
                            {{ $purchase->supplier->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <flux:modal.trigger name="edit_product">
                                    <flux:button variant="primary" color="blue" as="a" href="{{ route('admin.purchases.show', $purchase)}}">
                                        Ver Detalle
                                    </flux:button>
                                </flux:modal.trigger>
                                <div></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            
    </div>
</div>
