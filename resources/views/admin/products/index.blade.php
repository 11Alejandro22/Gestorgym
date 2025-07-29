
<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Producto
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <flux:heading class="mb-6 mt-6 ml-6" size="xl">Productos</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:button variant="primary" as="a" href="{{ route('admin.products.showProducts.table') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
            Gestionar Productos
        </flux:button>
    </div>

    @livewire('admin.product-row')

    

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