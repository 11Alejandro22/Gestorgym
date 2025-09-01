<x-layouts.app>

        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.gyms.index')">
                Gym
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" class="mt-6" level="1">Editar Gym</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Edite los datos del Gimansio</flux:text>
        <flux:separator class="border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg space-y-6">
            <flux:legend></flux:legend>
            <form action="{{route('admin.gyms.update', $gym->id)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre" name="name" value="{{old('name', $gym->name)}}" placeholder="Escribe el nombre del gymnasio"></flux:imput>

                <flux:input label="Direccion" name="address" type="text" value="{{old('address', $gym->address)}}" placeholder="Escribe una direccion"></flux:imput>

                <flux:input icon="envelope" label="Email" name="email" value="{{old('email', $gym->email)}}" placeholder="Email@correo.com"/>
                
                <flux:input icon="phone" label="Telefono" type="text" name="phone" mask="(9999) 99-99-99" value="{{old('phone', $gym->phone)}}" placeholder="(9999) 99-99-99"/>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Guardar
                    </flux:button>
                </div>
            </form>

        </div>


</x-layouts.app>