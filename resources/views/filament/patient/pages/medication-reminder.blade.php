// resources/views/filament/patient/pages/medication-reminder.blade.php
<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Enregistrer le médicament
        </x-filament::button>
    </x-filament-panels::form>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Médicaments enregistrés</h2>

        @foreach(auth()->user()->medications as $medication)
            <div class="border-b pb-4 mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-medium">{{ $medication->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $medication->dosage }}</p>
                        <p class="text-sm text-gray-500">
                            Pris à : {{ implode(', ', $medication->times) }}
                        </p>
                    </div>
                    <x-filament::button
                        wire:click="deleteMedication({{ $medication->id }})"
                        color="danger"
                        icon="heroicon-o-trash"
                    />
                </div>
            </div>
        @endforeach
    </div>

</x-filament-panels::page>
