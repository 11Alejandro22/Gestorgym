<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Entrenadores
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:heading class="mb-6 mt-6" size="xl">Entrenadores</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:button variant="primary" as="a" href="{{route('admin.coaches.create')}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
            Agregar
        </flux:button>
    </div>

        <div class="bg-gray px-6 py-2 shadow-lg rounded-lg space-y-6">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Perfil
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre y Apellido
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Telefono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Cambiar Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center" width="10px">
                                Edit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coaches as $coach)
                            @livewire('admin.coach-row', ['coach' => $coach], key($coach->id))
                        @endforeach
                    </tbody>
                </table>
                
            </div>

        </div>


</x-layouts.app>