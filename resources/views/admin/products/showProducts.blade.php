<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Gestión de Productos
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <flux:heading class="mb-6 mt-6 ml-6" size="xl">Lista de Productos</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:button variant="primary" as="a" href="" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
            Nuevo
        </flux:button>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                wire:click="toggle"
                                :checked="$product->is_active"
                                class="cursor-pointer"></flux:button>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <flux:button variant="primary" color="blue" as="a" href="{{ route('admin.products.edit', $product) }}">
                                    Editar
                                </flux:button>
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
            {{-- <div class="mt-4">
                {{ $product_types->links()}}
            </div> --}}
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