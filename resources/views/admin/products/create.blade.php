<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.products.index')">
                Producto
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-4 mt-6 ml-6" size="xl">Agrega un nuevo Producto</flux:heading>
        <flux:separator/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">
            <form action="{{route('admin.products.store')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div class="relative">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*"/>
                        </label>
                    </div> 
                </div>

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre de la marca"></flux:imput>

                <flux:input label="Precio (unitario)" icon="currency-dollar" type="number" name="price" value="{{ old('price') }}" placeholder="$999.99" />

                <flux:input label="Cantidad" placeholder="0" name="stock" value="{{ old('stock') }}"/>

                <flux:select label="Tipo de Producto" wire:model="industry" name="product_type_id" placeholder="Seleccione un Tipo...">
                    @foreach ($product_types as $product_type)
                        <option value="{{ $product_type->id }}"
                            {{ old('product_type_id') ==  $product_type->id ? 'selected' : '' }}>
                            {{ $product_type->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:select label="Marca" wire:model="industry" name="brand_id" placeholder="Seleccione una Marca...">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id') ==  $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </flux:select>
                
                <flux:textarea
                    label="Descripción (Opcional)"
                    name="description"
                    value="{{old('description')}}"
                    placeholder="Escriba una descripción"
                />

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>

        
</x-layouts.app>