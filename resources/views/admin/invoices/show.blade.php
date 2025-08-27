<x-layouts.app>

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.purchases.index')">
                Compras
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Detalle de Compra
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading class="mb-6 mt-6" size="xl">Detalle de Compra</flux:heading>
        <flux:separator class="mb-4 border-lime-500 border-1"/>

        <div class="border-lime-500 border-1 min-h-[200px] mb-6 bg-black-700 px-6 py-8 shadow-lg rounded-lg flex flex-col">
            <flux:heading size="xl" class="mb-2">Proveedor: {{ $purchase->supplier->name }}</flux:heading>
            <flux:heading size="lg">Fecha de Compra: {{ $purchase->purchase_date}}</flux:heading>
        </div>

        <!-- TABLA DE PRODUCTOS -->
        <div class="border-lime-500 border-1 min-h-[400px] bg-black-700 px-6 py-8 shadow-lg rounded-lg grid gap-4 grid-cols-1 md:[grid-template-columns:1fr_300px]">
            <div class="p-4 rounded shadow overflow-auto">
                <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-800 uppercase bg-lime-400 dark:bg-lime-700 dark:text-gray-100">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Marca</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Cant.</th>
                            <th class="px-6 py-3">Desc. (%)</th>
                            <th class="px-6 py-3">Desc. ($)</th>
                            <th class="px-6 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody>
                            @foreach ($purchaseDetails as $details)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $details->product->name }}</td>
                                    <td class="px-6 py-4">{{ $details->product->brand->name ?? 'Sin marca' }}</td>
                                    <td class="px-6 py-4">{{ $details->product->productType->name ?? 'Sin tipo' }}</td>
                                    <td class="px-6 py-4">${{ number_format($details->unit_price, 2) }}</td>
                                    <td class="px-6 py-4">{{ $details->quantity }}</td>
                                    <td class="px-6 py-4">{{ $details->discount_percentage }}%</td>
                                    <td class="px-6 py-4">${{ number_format($details->discount_amount, 2) }}</td>
                                    <td class="px-6 py-4">${{ number_format($details->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </tbody>
                </table>
            </div>

            <!-- TOTAL -->
            <div class="p-4 rounded shadow overflow-auto space-y-6 border-lime-500 border-1">
                <flux:heading size="xl" class="text-center mt-6 mb-8">Resumen</flux:heading>
                <div class="flex flex-col justify-end items-center mt-6">
                    <flux:text size="xl" class="text-gray-900 dark:text-gray-200 mb-4">Total</flux:text>
                    <flux:heading size="xl" class="mb-1 text-lime-700 dark:text-lime-300">
                        ${{ number_format($purchase->total, 2) }}
                    </flux:heading>
                </div>
            </div>
        </div>

</x-layouts.app>