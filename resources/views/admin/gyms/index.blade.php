<x-layouts.app>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Gym
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg space-y-6">
            
                <flux:fieldset>
                    <flux:legend>Datos del Gym</flux:legend>
                    <flux:input label="Nombre" class="max-w-full focus:outline-none" :value=" $gym->name ?? '' " readonly/>
                    <flux:input label="Dirección" class="max-w-full" :value=" $gym->address ?? '' " readonly/>
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                            <flux:input  icon="envelope" label="Email" :value=" $gym->email ?? '' " readonly/>
                            <flux:input icon="phone" label="Telefono" :value=" $gym->phone ?? '' " readonly/>
                        </div>
                    </div>
                </flux:fieldset>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" as="a" href="{{route('admin.gyms.create')}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                        Agregar
                    </flux:button>
                </div>

        </div>


</x-layouts.app>