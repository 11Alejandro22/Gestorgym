<x-layouts.app>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.coaches.index')">
                Entrenadores
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Agregar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg space-y-6">
            <flux:legend>Datos del Entrenador</flux:legend>
            <form action="{{route('admin.coaches.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre"   name="first_name" value="{{old('first_name')}}" placeholder="Escribe un nombre"></flux:imput>

                <flux:input label="Apellido" name="last_name" value="{{old('last_name')}}" placeholder="Escribe un apellido"></flux:imput>

                <flux:input icon="identification" label="DNI" name="DNI" type="text" value="{{old('DNI')}}" placeholder="Escriba un DNI"></flux:imput>

                <flux:input icon="phone"  label="Telefono" type="text" name="phone" mask="(999) 9999-999" value="{{old('phone')}}" placeholder="(9999) 999-999"/>
                
                <flux:input icon="envelope" label="Email" name="email" value="{{old('email')}}" placeholder="Email@correo.com"/>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


</x-layouts.app>