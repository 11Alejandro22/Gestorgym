<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.product_types.index')">
                Tipos de Productos
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Nuevo Tipo de Producto</flux:heading>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.product_types.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre del tipo de producto"></flux:imput>
                
                <flux:textarea
                    label="Descripción (Opcional)*"
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