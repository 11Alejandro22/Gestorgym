<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.index')">
                Marcas
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-4 mt-6 ml-6" size="xl">Agrega una nueva Marca</flux:heading>
        <flux:separator/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.brands.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre de la marca"></flux:imput>
                
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