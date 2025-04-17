<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="calculerDose">
        {{ $this->form }}

        <div class="flex justify-between items-center mt-6">
            <x-filament::button type="submit" icon="heroicon-o-calculator">
                Calculer la dose
            </x-filament::button>

            @if ($doseInsuline)
                <div class="text-lg font-semibold bg-primary-50 px-4 py-2 rounded-lg">
                    Dose recommandée: <span class="text-primary-600">{{ $doseInsuline }}</span> unités
                </div>

                <x-filament::button wire:click="enregistrer" type="submit" icon="heroicon-o-save">
                    Enregistrer
                </x-filament::button>
            @endif
        </div>
    </x-filament-panels::form>


</x-filament-panels::page>
