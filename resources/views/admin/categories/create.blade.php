<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categories.index')">
                Categorias
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.categories.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre de la categoría"></flux:imput>

                <flux:input label="Precio" name="monthly_price" type="number" value="{{old('monthly_price')}}" placeholder="$"></flux:imput>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>

        
</x-layouts.app>