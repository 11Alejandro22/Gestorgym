<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.product_types.index')">
                Tipos de Productos
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6 ml-6" size="xl">Edición de Tipo de Producto</flux:heading>
        <flux:separator class="mb-4"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{ route('admin.product_types.update', $product_type)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre" name="name" value="{{old('name', $product_type->name)}}" placeholder="Escribe el nombre del tipo de producto"></flux:imput>

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <textarea id="message" rows="4" name="description" value="{{ old('description', $product_type->description )}}"  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-300 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $product_type->description }}</textarea>

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>
        </div>

</x-layouts.app>