<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.clients.index')">
                Clientes
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Edit 
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-4 mt-6" size="xl">Modificación de Cliente</flux:heading>
        <flux:separator/>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">

            <form action="{{route('admin.clients.update', $client)}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <flux:input label="Nombre"   name="first_name" value="{{old('first_name', $client->person->first_name)}}" placeholder="Escribe un nombre"></flux:imput>

                <flux:input label="Apellido" name="last_name"  value="{{old('last_name', $client->person->last_name)}}"  placeholder="Escribe un apellido"></flux:imput>

                <flux:input label="DNI"      name="DNI"        value="{{old('DNI', $client->person->DNI)}}"        placeholder="Escriba un DNI"   icon="identification" type="text"  ></flux:imput>

                <flux:input label="Telefono" name="phone"      value="{{old('phone', $client->person->phone)}}"      placeholder="(9999) 999-999"   icon="phone" type="text"  mask="(999) 9999-999"  />
                
                <flux:input label="Email"    name="email"      value="{{old('email', $client->person->email)}}"      placeholder="Email@correo.com" icon="envelope" />
                
                
                <div class="bg-gray px-6 py-8 rounded-lg grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($schedules as $schedule)
                        <label for="" class="cursor-pointer">
                            <div class="scale-100 w-full [@media(min-width:450px)]:w-[350px] shadow-lg p-4 bg-white border border-gray-200 rounded-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                {{-- categoria --}}
                                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">{{ $schedule->category->name }}</h5>
                                <div class="flex items-baseline text-gray-900 dark:text-white">
                                    <span class="text-3xl font-semibold">$</span>
                                    {{-- precio --}}
                                    <span class="text-5xl font-extrabold tracking-tight">{{$schedule->category->monthly_price}}</span>
                                    <span class="ms-1 text-xl font-normal text-gray-500 dark:text-gray-400">/Mes</span>
                                </div>
                                <ul role="list" class="space-y-5 my-7">
                                    <li class="flex items-center">
                                        <svg class="shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Profesor: {{ $schedule->user->name }}</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Dias:
                                            @foreach ($schedule->days as $day)
                                                <flux:badge variant="solid" color="sky">
                                                    {{ $day->name }}
                                                </flux:badge>
                                            @endforeach
                                        </span>
                                    </li>
                                    <li class="flex">
                                        <svg class="shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Horario: {{ $schedule->start_time }}h - {{ $schedule->end_time }}h</span>
                                    </li>
                                    
                                </ul>
                                <div class="w-full max-w-sm flex justify-center items-center mb-4">
                                    <flux:checkbox 
                                    class="scale-150 cursor-pointer" 
                                    name="category_schedules[]"
                                    :value="$schedule->id"
                                    :checked="in_array($schedule->id, old('category_schedules', $selectedSchedules))"/>
                                </div>
                                
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        Guardar
                    </flux:button>
                </div>
            </form>

        </div>


        
</x-layouts.app>