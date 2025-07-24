<x-layouts.app>
        <div class="mb-4 flex justify-between items-center">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')">
                    Dashboard
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item>
                    Horarios
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:heading class="mb-6 mt-6" size="xl">Horarios de Entreno</flux:heading>
        <flux:separator class="mb-4"/>

        <div class="mb-4 flex justify-end items-center">
            <flux:button variant="primary" as="a" href="{{route('admin.category_schedules.create')}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                Nuevo Horario
            </flux:button>
        </div>

        <div class="bg-gray px-6 py-4 shadow-lg rounded-lg space-y-6">
            
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Categoría
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Profesor
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Días
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Horario
                                </th>
                                <th scope="col" class="px-6 py-3" width="10px">
                                    Edit
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200" >
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$schedule->category->name}}
                                    </th>
                                    <td class="px-6 py-4 font-medium text-1xl">
                                        {{$schedule->user->name}}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-1xl">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($schedule->days as $day)
                                                <flux:badge variant="solid" color="sky">
                                                    {{ $day->name }}
                                                </flux:badge>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-1xl">
                                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <flux:button variant="primary" as="a" href="{{route('admin.category_schedules.edit', $schedule)}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
                                                Editar
                                            </flux:button>
                                            
                                            <form class="delete-form" action="{{route('admin.category_schedules.destroy', $schedule)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button variant="danger" type="submit" class="cursor-pointer">Eliminar</flux:button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    
                </div>

        </div>

        @push('js')
        
        @endpush

</x-layouts.app>