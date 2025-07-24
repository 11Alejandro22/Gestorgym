<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Clientes
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <flux:heading class="mb-6 mt-6" size="xl">Clientes</flux:heading>
    <flux:separator class="mb-4"/>

    <div class="mb-4 flex justify-end items-center">
        <flux:button variant="primary" as="a" href="{{route('admin.clients.create')}}" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition cursor-pointer">
            Nuevo
        </flux:button>
    </div>


    @livewire('admin.clients-index')

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
</x-layouts.app>