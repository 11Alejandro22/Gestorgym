<x-layouts.app>
        @if (session('message'))
            <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                <div class="flex items-center">
                    <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-xl font-medium">¡Alerta Información importante!</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    {{ session('message') }}
                </div>
            </div>
        @endif


        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.gyms.index')">
                Gym
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Agregar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg space-y-6">
            <flux:legend>Datos del Gym</flux:legend>
            <form action="{{route('admin.gyms.store')}}" method="POST" class="space-y-6">
                @csrf

                <flux:input label="Nombre" name="name" value="{{old('name')}}" placeholder="Escribe el nombre del gymnasio"></flux:imput>

                <flux:input label="Direccion" name="address" type="text" value="{{old('address')}}" placeholder="Escribe una direccion"></flux:imput>

                <flux:input icon="envelope" label="Email" name="email" value="{{old('email')}}" placeholder="Email@correo.com"/>
                
                <flux:input icon="phone" label="Telefono" type="text" name="phone" mask="(9999) 99-99-99" value="{{old('phone')}}" placeholder="(9999) 99-99-99"/>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>


</x-layouts.app>