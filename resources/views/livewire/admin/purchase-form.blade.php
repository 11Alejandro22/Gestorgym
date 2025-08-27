<div>
    <!-- Cambié el método para que sea guardarCompra en vez de addProduct -->
    <form wire:submit.prevent="guardarCompra" class="space-y-6">

        <!-- FORMULARIO DE CARGA DE PRODUCTOS -->
        <div class="min-h-[400px] bg-black-700 px-6 py-8 rounded-lg grid gap-4 grid-cols-1">

            <!-- Selección de proveedor -->
            <flux:select wire:model.live="supplier_id" label="Proveedor">
                <flux:select.option value="">Seleccionar</flux:select.option>
                @foreach ($suppliers as $supplier)
                    <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <!-- Cantidad -->
            <flux:input label="Cantidad" wire:model="stock" type="number" min="1"></flux:input>

            <!-- Precio -->
            <flux:input label="Precio de Compra" wire:model="price" type="number" step="0.01" min="0"></flux:input>

            <!-- Descuento (%) -->
            <flux:input label="Descuento (%) Opcional" wire:model="discount_percentage" type="number" min="0" max="100"></flux:input>

            <!-- Descuento ($) -->
            <flux:input label="Descuento ($) Opcional" wire:model="discount_amount" type="number" min="0"></flux:input>

            <!-- Producto -->
            <flux:select wire:model="selectedProductId" name="product_id" label="Productos">
                <flux:select.option value="">-- Selecciona un producto --</flux:select.option>
                @foreach($products as $product)
                    <flux:select.option value="{{ $product->id }}">{{ $product->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <!-- Botón agregar -->
            <div class="flex justify-end">
                <flux:button icon="plus" variant="primary" type="button" class="cursor-pointer" wire:click="addProduct">
                    Agregar
                </flux:button>
            </div>
        </div>

        <!-- TABLA DE PRODUCTOS -->
        <div class="border-lime-500 border-1 min-h-[400px] bg-black-700 px-6 py-8 shadow-lg rounded-lg grid gap-4 grid-cols-1 md:[grid-template-columns:1fr_300px]">
            <div class="p-4 rounded shadow overflow-auto">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-800 uppercase bg-lime-400 dark:bg-lime-700 dark:text-gray-100">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Marca</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Cant.</th>
                            <th class="px-6 py-3">Desc. (%)</th>
                            <th class="px-6 py-3">Desc. ($)</th>
                            <th class="px-6 py-3">Subtotal</th>
                            <th class="px-6 py-3">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedProducts as $index => $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $product['name'] }}</td>
                                <td class="px-6 py-4">{{ $product['brand'] }}</td>
                                <td class="px-6 py-4">{{ $product['product_type'] }}</td>
                                <td class="px-6 py-4">${{ number_format($product['price'], 2) }}</td>
                                <td class="px-6 py-4">
                                    <input
                                        type="number"
                                        min="1"
                                        class="w-20 rounded px-2 py-1 border-1"
                                        wire:model.lazy="selectedProducts.{{$index}}.quantity"
                                        wire:change="updateQuantity({{ $index }}, $event.target.value)"
                                    >
                                </td>
                                <td class="px-6 py-4">{{ $product['discount_percentage'] }}%</td>
                                <td class="px-6 py-4">${{ number_format($product['discount_amount'], 2) }}</td>
                                <td class="px-6 py-4">${{ number_format($product['subtotal'], 2) }}</td>
                                <td class="px-6 py-4">
                                    <flux:button variant="danger" class="cursor-pointer" wire:click="removeProduct({{ $index }})">X</flux:button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- TOTAL -->
            <div class="p-4 rounded shadow overflow-auto space-y-6 border-lime-500 border-1">
                <flux:heading size="xl" class="text-center mt-6 mb-8">Resumen</flux:heading>
                <div class="flex flex-col justify-end items-center mt-6">
                    <flux:text size="xl" class="text-gray-900 dark:text-gray-200 mb-4">Total</flux:text>
                    <flux:heading size="xl" class="mb-1 text-lime-700 dark:text-lime-300">
                        ${{ number_format($this->total, 2) }}
                    </flux:heading>
                </div>
                <flux:button variant="primary" type="submit" class="w-full cursor-pointer">Guardar Compra</flux:button>
            </div>
        </div>
    </form>
</div>