<x-filament-panels::page>
    <div class="space-y-4">
        <input
            wire:model.debounce.500ms="search"
            type="text"
            placeholder="Rechercher un médecin..."
            class="filament-input w-full max-w-md"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->doctors as $doctor)
                <div class="bg-white p-4 rounded shadow text-center">
                    <img src="{{ asset('doctor.jpeg') }}" class="w-24 h-24 mx-auto rounded-full object-cover" alt="">
                    <div class="mt-2 font-medium">{{ $doctor->name }}</div>
                    <div class="text-sm text-gray-500">{{ $doctor->email }}</div>
                    <button wire:click="requestFollow({{ $doctor->id }})" class="mt-3 filament-button">
                        Demander
                    </button>
                </div>
            @endforeach
        </div>

        {{ $this->doctors->links() }}
    </div>
</x-filament-panels::page>
