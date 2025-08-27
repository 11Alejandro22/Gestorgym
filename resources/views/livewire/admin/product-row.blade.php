<div>
    <div class="mb-4 p-2 flex justify-center items-center space-x-4">
        <flux:input 
            wire:model.live.debounce.500ms="first_name" 
            class="w-100" 
            icon="magnifying-glass"  
            placeholder="Filtrar por Nombre"
        />

        <flux:select wire:model.live="brand_id" placeholder="Filtrar por Marca">
            <flux:select.option value="">Todas las Marcas</flux:select.option>
            @foreach ($brands as $brand)
                <flux:select.option value="{{ $brand->id }}">{{ $brand->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="product_type_id" placeholder="Filtrar por Tipo de Producto">
            <flux:select.option value="">Todos los Productos</flux:select.option>
            @foreach ($product_types as $product_type)
                <flux:select.option value="{{ $product_type->id }}">{{ $product_type->name }}</flux:select.option>
            @endforeach
        </flux:select>
        
    </div>

    <div class="bg-gray px-4 py-8 rounded-lg grid gap-2 md:grid-cols-2 lg:grid-cols-3">
        @forEach($products as $product)
            <div class="w-full max-w-sm bg-white  border border-gray-200 rounded-lg shadow-sm dark:bg-transparent dark:text-gray-800 dark:border-lime-800">
                <div>
                    <img 
                        class="p-4 rounded-t-lg w-80 h-95 object-cover mx-auto rounded-2xl" 
                        src="{{ Storage::url($product->image) }}" 
                        alt="Imagen del producto" 
                    />
                </div>
                <div class="px-5 pb-5">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->nombre_producto }} / {{ $product->marca }}</h5>
                    </a>
                    <div class="flex items-center mt-2.5 mb-5">
                        
                    </div>
                    <div class="flex items-center justify-between ">
                        <span class="text-3xl font-bold text-lime-700 dark:text-lime-300">
                            ${{ number_format($product->price, 0, ',', '.') }}
                        </span>

                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            Stock: {{ $product->stock}}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
