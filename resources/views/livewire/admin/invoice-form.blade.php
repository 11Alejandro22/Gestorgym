<div>
    <form wire:submit.prevent="guardarVenta">

        <div>
            <div class="bg-black-700 rounded-lg">
                <div>
                    <label for="">Cantidad</label>
                    <flux:input class="mb-4 py-2" wire:model="quantity" type="number" name="quantity"></flux:input>
                </div>

                <div class="flex">
                    <div class="w-full mr-4">
                        <label for="">Producto</label>
                        <flux:input class="cursor-pointer mb-4 py-2" icon="magnifying-glass" placeholder="Nombre del producto" wire:model.live.debounce.500ms="product" name="productos" value="Buscar Producto"></flux:input>
                    </div>
                    
                    <div class="w-full mr-4">
                        <label for="" class="cursor-pointer mb-4 py-2">Marca</label>
                        <flux:select wire:model.live="brand_id" name="brand_id" label="">
                            <flux:select.option value="">-- Selecciona una Marca --</flux:select.option>
                            @foreach($brands as $brand)
                                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                    
                </div>
            </div>

            <div class="w-full h-auto flex flex-col md:flex-row gap-4">
                @foreach($products as $product)
                <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="p-4 rounded-t-lg w-65 h-75 object-cover mx-auto rounded-2xl" src="{{ Storage::url($product->image) }}" alt="product image" />
                    </a>
                    <div class="px-5 pb-5">
                        <a href="#">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}/ {{ $product->brand->name }}</h5>
                        </a>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ $product->price }}</span>
                            
                            <flux:button icon="plus" variant="primary" type="button" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer" wire:click="addProduct({{ $product->id }})">
                                Add to cart
                            </flux:button>
                        </div>
                        <span> stock:{{ $product->stock }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @if ($stockError)
                <div class="p-4 mb-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 
                            dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Danger alert!</span> {{ $stockError }}
                </div>
            @endif
        </div>

        <!-- TABLA DE PRODUCTOS -->
        <div class="border-lime-500 border-1 min-h-[400px] bg-black-700 mt-4 px-6 py-8 shadow-lg rounded-lg grid gap-4 grid-cols-1 md:[grid-template-columns:1fr_300px]">
            <div class="p-4 rounded shadow overflow-auto">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-800 uppercase bg-lime-400 dark:bg-lime-700 dark:text-gray-100">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Marca</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Cant.</th>
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
                <flux:button variant="primary" type="submit" class="w-full cursor-pointer">Guardar</flux:button>
            </div>
        </div>
    </form>
    
</div>
