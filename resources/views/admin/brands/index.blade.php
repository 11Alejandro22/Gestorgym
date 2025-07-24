
<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Marcas
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <flux:heading class="mb-6 mt-6 ml-6" size="xl">Lista de Marcas</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:button variant="primary" as="a" href="{{route('admin.brands.create')}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
            Nuevo
        </flux:button>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
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
            @foreach ($brands as $brand)
                @livewire('admin.brand-row', ['brand' => $brand], key($brand->id))
            @endforeach
            </tbody>
        </table>
            <div class="mt-4">
                {{ $brands->links()}}
            </div>
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