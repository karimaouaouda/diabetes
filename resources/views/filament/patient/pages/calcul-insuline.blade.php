<x-filament::page>
    <x-filament::form wire:submit="submit">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Calculer l'insuline
        </x-filament::button>
        <x-filament::button type="button" class="mt-4" wire:click="resetForm">
            Réinitialiser
        </x-filament::button>
        <x-filament::button type="button" class="mt-4" wire:click="calculateInsulin">
            Calculer
        </x-filament::button>
        <x-filament::button type="button" class="mt-4" wire:click="showResult">
            Afficher le résultat
        </x-filament::button>
        <x-filament::button type="button" class="mt-4" wire:click="showGraph">
            Afficher le graphique
        </x-filament::button>
    </x-filament::form>
</x-filament::page>
