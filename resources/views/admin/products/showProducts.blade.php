<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.products.index')">
                Productos
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Gestión de Productos
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <flux:heading class="mb-6 mt-6 ml-6" size="xl">Lista de Productos</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:modal.trigger name="create_product">
            <flux:button variant="primary" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                Nuevo
            </flux:button>
        </flux:modal.trigger>
    </div>
    

    @livewire('admin.manage-products')

    
    <div class="space-y-6">
        <flux:modal name="create_product" class="min-w-[450px] max-w-[900px] w-full mb-8">
            <form action="{{route('admin.products.store')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div class="relative w-full h-95 flex justify-center items-center mt-4">
                    <img 
                        src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" 
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

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre de la marca"></flux:imput>

                <flux:input label="Precio (unitario)" icon="currency-dollar" type="number" name="price" value="{{ old('price') }}" placeholder="$999.99" />

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

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" class="cursor-pointer" variant="primary">Guardar</flux:button>
                </div>
            </form>
        </flux:modal>
    </div>

    
    
    

    @push('js')
        <script>
            forms = document.querySelectorAll('.delete-form');

            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    Swal.fire({
                        title: "Estas Seguro?",
                        text: "¡No podrás revertir esto y los datos asociados se perderan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Eliminarlo!",
                        cancelButtonText: "Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                        });

                });
            });
        </script>
    @endpush
</x-layouts.app>