<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.suppliers.index')">
                Proveedores
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Editar Proveedor</flux:heading>
        <flux:separator class="mb-4"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.suppliers.update', $supplier)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre"   name="name" value="{{old('name', $supplier->name)}}" placeholder="Escribe el nombre de la categoría"></flux:imput>

                <flux:input label="Telefono" name="phone" type="number" value="{{old('phone', $supplier->phone)}}" placeholder="9999-99-99-99"></flux:imput>

                <flux:input label="Email"    name="email" type="email" value="{{old('email', $supplier->email)}}" placeholder="correo@gmail.com"></flux:imput>

                <flux:input label="Dirección" name="address" type="text" value="{{old('address', $supplier->address)}}" placeholder="Dirección"></flux:imput>

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


        
</x-layouts.app>