<x-layouts.app>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.coaches.index')">
                Entrenadores
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Editar Entrenador</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Edite los datos del Entrenador</flux:text>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg space-y-6">
            
            <form action="{{route('admin.coaches.update', $coach)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <flux:input label="Nombre"   name="first_name" value="{{old('first_name', $coach->person->first_name)}}" placeholder="Escribe un nombre"></flux:imput>

                <flux:input label="Apellido" name="last_name" value="{{old('last_name', $coach->person->last_name)}}" placeholder="Escribe un apellido"></flux:imput>

                <flux:input icon="identification" label="DNI" name="DNI" type="text" value="{{old('DNI', $coach->person->DNI)}}" placeholder="Escriba un DNI"></flux:imput>

                <flux:input icon="phone"  label="Telefono" type="text" name="phone" mask="(999) 9999-999" value="{{old('phone', $coach->person->phone)}}" placeholder="(9999) 999-999"/>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


</x-layouts.app>