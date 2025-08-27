<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.products.showProducts.table')">
                Gestión de Producto
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6 ml-6" size="xl">Lista de Marcas</flux:heading>
        <flux:separator class="mb-4"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">
            <form action="{{route('admin.products.update', $product)}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="relative w-80 h-95">
                    <img 
                        src="{{ $product->image ? Storage::url($product->image) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg'}} " 
                        alt="Imagen del producto"
                        class="w-80 h-95 aspect-video object-cover object-center rounded"
                        id="imgPreview"
                    />
                    <div class="absolute top-4 right-2">
                        <label for="image" class="cursor-pointer bg-gray-600 text-white p-2 rounded dark:bg-gray-600">
                            Subir Imagen
                            <input type="file" id="image" name="image" accept="image/*" class="hidden"  onchange="previewImage(event, '#imgPreview')">
                        </label>
                    </div>
                </div>

                <flux:input label="Nombre" name="name" value="{{old('name', $product->name)}}" placeholder="Escribe el nombre de la marca"></flux:imput>

                <flux:input label="Precio (unitario)" icon="currency-dollar" type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="$999.99" />

                <flux:select label="Tipo de Producto" wire:model="industry" name="product_type_id" placeholder="Seleccione un Tipo...">
                    @foreach ($product_types as $product_type)
                        <option value="{{ $product_type->id }}"
                            {{ old('product_type_id',$product_type->id) ==  $product_type->id ? 'selected' : '' }}>
                            {{ $product_type->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:select label="Marca" wire:model="industry" name="brand_id" placeholder="Seleccione una Marca...">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $brand->id) ==  $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </flux:select>
                
                <flux:textarea
                    label="Descripción (Opcional)"
                    name="description"
                    value="{{old('description')}}"
                    placeholder="Escriba una descripción">
                    {{ $product->description }}
                </flux:textarea>

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" class="cursor-pointer" variant="primary">Guardar</flux:button>
                </div>
            </form>

        </div>

</x-layouts.app>