<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Venta
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:heading class="mb-6 mt-6" size="xl">Facturación</flux:heading>
    <flux:separator class="mb-4 border-lime-500 border-1"/>

    <div class="bg-black-700 py-4 rounded-lg grid gap-4 grid-cols-3">
            <div>
                <label>Fecha</label>
                <flux:input class="mb-4 py-2 hover:none" wire:model="stock" type="text" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}"  placeholder="" readonly ></flux:input>
            </div>

            <div>
                <label>N° Factura</label>
                <flux:input class="mb-4 py-2" wire:model="stock" readonly 
                    value="{{ $lastInvoiceNumber->invoice_number ?? 0 }}">
                </flux:input>
            </div>

            <div>
                <label>Cliente</label>
                <flux:input class="mb-4 py-2" wire:model="price" placeholder="Consumidor Final" readonly value="Consumidor Final"></flux:input>
            </div>
    </div>

    @livewire('admin.invoice-form')


    @push('js')
        <script>
            
            forms = document.querySelectorAll('.delete-form');

            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    Swal.fire({
                        title: "Estas Seguro?",
                        text: "¡No podrás revertir esto y los datos asociados se perderan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Eliminarlo!",
                        cancelButtonText: "Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                        });

                });
            });
        </script>
    @endpush
</x-layouts.app>