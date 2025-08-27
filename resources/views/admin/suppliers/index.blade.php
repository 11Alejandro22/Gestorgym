


<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Proveedores
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        
    </div>

    <flux:heading class="mb-6 mt-6" size="xl">Lista de Proveedores</flux:heading>
    <flux:separator class="mb-4 border-lime-500 border-1"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:modal.trigger name="create_product">
            <flux:button variant="primary" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                Nuevo
            </flux:button>
        </flux:modal.trigger>
    </div>


    @livewire('admin.supplier-row')


    <div class="space-y-6">
        <flux:modal name="create_product" class="min-w-[450px] max-w-[900px] w-full mb-8 ">
            <div class="pb-8 pt-8">
                <flux:heading size="xl" class="mb-8">Nuevo Proveedor</flux:heading>
            </div>

            <form action="{{route('admin.suppliers.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre del proveedor "></flux:imput>

                <flux:input label="Telefono"  icon="phone" type="number" name="phone"   value="{{ old('phone') }}"   placeholder="9999-99-99-99" />

                <flux:input label="Email"     icon="currency-dollar" type="email"  name="email"   value="{{ old('email') }}"   placeholder="Correo@email.com" />

                <flux:input label="Dirección" type="text"   name="address" value="{{ old('address') }}" placeholder="Dirección del proveedor"/>


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