

<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.clients.index')">
                Clientes
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Pago
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>



        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">
            
            <flux:heading class="mb-6" size="xl">Pago de Mensualidad</flux:heading>
            <div class="w-80 mt-4 mb-6">
                <flux:text size="xl" class="mb-4">Cliente: {{$client->person->first_name}} {{$client->person->last_name}} </flux:text>

                <flux:text size="xl">Vencimiento: {{ $installment->due_date}} </flux:text>
            </div>

            <div class="mt-4 relative overflow-x-auto">
                
                <div class="mt-4 relative overflow-x-auto grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded">
                        <table class="w-full text-xl text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-s-lg">
                                        Categoría 
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Precio
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($category_schedules as $category_schedule)
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $category_schedule->category->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            
                                        </td>
                                        <td class="px-6 py-4">
                                            
                                        </td>
                                        <td class="px-6 py-4">
                                            
                                        </td>
                                        <td class="px-6 py-4">
                                            ${{ $category_schedule->category->monthly_price }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                
                        </table>
                    </div>
                    <div class="p-4 rounded flex justify-center items-center flex-col border border-lime-400">
                        <flux:heading size="xl" class="mb-8">Resumen de Pago</flux:heading>
                        <div class="flex items-center flex-col">
                            <flux:heading size="xl" class="mb-4">Total</flux:heading>
                            <flux:heading size="xl" class="mb-1 text-lime-400">${{ number_format($total) }}</flux:heading>
                        </div>
                        <div class="mb-4 flex justify-end items-center">
                            <flux:button
                                variant="primary"
                                icon="banknotes"
                                as="button"
                                data-modal-target="crud-modal"
                                data-modal-toggle="crud-modal"
                                class="flex items-center gap-2 px-4 py-2 mt-4 bg-green-700 text-white rounded hover:bg-green-900 transition cursor-pointer"
                            >
                                Pagar
                            </flux:button>
                        </div>
                        
                    </div>
                </div>
                @if ($errors->has('payment_method_id'))
                    <div class="flex justify-center items-center p-4 mb-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Error</span>
                        <div>
                            <span class="font-medium">Error:</span> {{ $errors->first('payment_method_id') }}
                        </div>
                    </div>
                @endif
            </div>

            
            
        </div>

        <div class="bg-gray px-6 py-8 shadow-lg rounded-lg">
            
            <flux:heading class="mb-4" size="xl">Historial de Pago</flux:heading>

            <div class="mt-4 relative overflow-x-auto">
                <div class="mt-4 mb-4">
                    {{ $historial->links() }}
                </div>
                <table class="w-full text-xl text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-s-lg">Fecha de pago</th>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3">Metodo de Pago</th>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3 rounded-e-lg">$ Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial as $item)
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') }}
                                </th>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4">{{ $item->metodo_pago }}</td>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4">$ {{ number_format($item->amount_paid) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                
        </div>
    

    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Metodo de Pago
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" action="{{ route('admin.clients.payments.store', $client->id) }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente</label>
                            <input type="text" readonly id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  value="{{$client->person->first_name}} {{$client->person->last_name}}" required="">
                        </div>

                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto a Pagar</label>
                            <input type="text" readonly  id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  value="{{ number_format($total) }}" required="">
                        </div>
                        
                        <div class="col-span-2 sm:col-span-2">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Metodo de Pago</label>
                            <select name="payment_method_id" id="category" class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Seleccione</option>
                                @foreach($paymentMethod as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <flux:button
                    variant="primary"
                    icon="banknotes"
                    type="submit"
                    
                    class="flex items-center gap-2 px-4 py-2 bg-green-700 text-white rounded hover:bg-green-900 transition cursor-pointer">
                    Pagar
                    </flux:button>
                </form>
            </div>
        </div>

    


        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="//unpkg.com/alpinejs" defer></script>
            <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
        @endpush
</x-layouts.app>