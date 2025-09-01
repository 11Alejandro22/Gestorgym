<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.category_schedules.index')">
                Horarios
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Editar Horario</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Edite los datos del Horario</flux:text>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.category_schedules.update', $category_schedule) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:select label="Categoría" wire:model="industry" name="category_id" placeholder="Elija una Categoría...">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (old('category_id', $category_schedule->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:select label="Profesor" wire:model="industry" name="user_id" placeholder="Elija un Profesor...">
                    @foreach ($coaches as $coach)
                        <option value="{{ $coach->id }}"
                            {{ (old('user_id', $category_schedule->user_id) == $coach->id) ? 'selected' : '' }}>
                            {{ $coach->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:input.group label="Rango de Horario">
                    <flux:input 
                        name="start_time" 
                        type="time" 
                        value="{{ old('start_time', $category_schedule->start_time) }}"
                    />
                    <flux:input 
                        name="end_time" 
                        type="time" 
                        value="{{ old('end_time', $category_schedule->end_time) }}"
                    />
                </flux:input.group>

                <flux:checkbox.group wire:model="Días" label="Días" class="flex space-x-4">
                    @foreach ($days as $day)
                        <flux:checkbox 
                            :label="$day->name" 
                            name="day_id[]"
                            :value="$day->id"
                            :checked="in_array($day->id, old('day_id', $category_schedule->days->pluck('id')->toArray()))"
                            class="cursor-pointer" 
                        />
                    @endforeach
                    <flux:checkbox label="" class="hidden" /> 
                </flux:checkbox.group>
                
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Enviar
                    </flux:button>
                </div>
            </form>

        </div>

</x-layouts.app>