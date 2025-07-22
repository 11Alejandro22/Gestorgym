
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="mb-4 p-2 flex justify-center items-center space-x-4">
        <flux:input 
            wire:model.live.debounce.500ms="first_name" 
            class="w-100" 
            icon="magnifying-glass"  
            placeholder="Filtrar por Nombre"
        />
        <flux:input 
            wire:model.live.debounce.500ms="last_name" 
            class="w-100" 
            icon="magnifying-glass"  
            placeholder="Filtrar por Apellido"
        />

        <flux:input 
            wire:model.live.debounce.500ms="DNI" 
            class="w-10" 
            icon="magnifying-glass"  
            placeholder="Filtrar por DNI"
        /> 
        
        <flux:select wire:model.live="is_active" placeholder="Seleccione un estado">
            <flux:select.option value="">Todos</flux:select.option>
            <flux:select.option value="1">Activos</flux:select.option>
            <flux:select.option value="0">Baja</flux:select.option>
        </flux:select>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded">
        <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Nombre y Apellido</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="text-star">Estado Mensualidad</th>
                <th scope="col" class="px-6 py-3 text-center" width="10px">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr class="bg-white-300 border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $result->id }}
                    </th>
                    <td class="px-6 py-4 font-medium text-1xl text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $result->person->first_name }} {{ $result->person->last_name }}
                    </td>
                    <td class="w-140 px-4 py-4 font-medium text-1xl">
                        <flux:badge variant="solid" color="{{ $result->is_active ? 'green' : 'red' }}">
                            {{ $result->is_active ? 'Activo' : 'Desactivado' }}
                        </flux:badge>
                    </td>

                    <td class="w-70 px-4 py-4 font-medium text-1xl">
                        @php
                            $installment = $result->installments->first();

                            if ($installment) {
                                switch ($installment->status?->id) {
                                    case 1:
                                        $estado = 'Al día';
                                        $color = 'green';
                                        break;
                                    case 2:
                                        $estado = 'Adeudando';
                                        $color = 'yellow';
                                        break;
                                    case 3:
                                        $estado = 'Cancelado';
                                        $color = 'red';
                                        break;
                                }
                            }
                        @endphp

                        <flux:badge variant="solid" color="{{ $color }}">
                            {{ $estado }}
                        </flux:badge>
                    </td>
                    
                    <td class="px-6 py-4">
                        
                        <div class="flex space-x-6">
                            <flux:button variant="primary" as="a"
                                icon="banknotes"
                                href="{{ route('admin.clients.payments.form', $result) }}"
                                class="flex items-center gap-2 px-4 py-2 bg-green-700 text-white rounded hover:bg-green-900 transition cursor-pointer">
                            </flux:button>
                            
                            <flux:button variant="primary" as="a"
                                icon="pencil-square"
                                href="{{ route('admin.clients.edit', $result) }}"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-900 transition cursor-pointer">
                            </flux:button>

                            <flux:button
                                x-data=""
                                x-on:click="Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: '¡Esto cambiará el estado!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sí, cambiar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.toggleIsActive({{ $result->id }})
                                    }
                                })"
                                icon="{{ $result->is_active ? 'x-mark' : 'check' }}"
                                variant="{{ $result->is_active ? 'danger' : 'primary' }}"
                                class="cursor-pointer bg-green-500 text-white hover:text-black hover:bg-green-600 "
                            ></flux:button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
