<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.index')">
                Marca
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Editar Marca</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Edite los datos de la marca</flux:text>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.brands.update', $brand)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre" name="name" value="{{old('name', $brand->name)}}" placeholder="Escribe el nombre de la marca"></flux:imput>

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <textarea id="message" rows="4" name="description" value="{{ old('description', $brand->description )}}"  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-300 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $brand->description }}</textarea>

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


        
</x-layouts.app>