<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categories.index')">
                Categorias
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Editar Categoria</flux:heading>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.categories.update', $category)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre" name="name" value="{{old('name', $category->name)}}" placeholder="Escribe el nombre de la categoría"></flux:imput>

                <flux:input label="Precio" icon="banknotes" name="monthly_price" type="number" value="{{old('monthly_price', $category->monthly_price)}}" placeholder="$99.99"></flux:imput>

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


        
</x-layouts.app>