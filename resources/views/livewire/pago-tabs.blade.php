<div>
    <div>
        <ul class="flex border-b mb-4">
            <li class="mr-4">
                <a href="#" wire:click.prevent="setActiveTab('pago')"
                class="cursor-pointer py-2 px-4 font-semibold {{ $activeTab === 'pago' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500' }}">
                Pago
                </a>
            </li>
            <li>
                <a href="#" wire:click.prevent="setActiveTab('historial')"
                class="cursor-pointer py-2 px-4 font-semibold {{ $activeTab === 'historial' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500' }}">
                Historial
                </a>
            </li>
        </ul>

        @if ($activeTab === 'pago')
            <div>
                {{-- Aquí va tu contenido de Pago --}}
                <h2>Pago de Mensualidad para {{ $client->person->first_name }} {{ $client->person->last_name }}</h2>
                {{-- Pone aquí tu tabla, botones, etc --}}
            </div>
        @endif

        @if ($activeTab === 'historial')
            <div>
                <h2>Historial de Pago para {{ $client->person->first_name }} {{ $client->person->last_name }}</h2>
                @livewire('historial-pagos', ['client_id' => $client->id])
            </div>
        @endif
    </div>
</div>
