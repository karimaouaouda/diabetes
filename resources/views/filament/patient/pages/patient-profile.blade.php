<x-filament::page>
    <x-filament::form wire:submit="submit">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Sauvegarder les modifications
        </x-filament::button>
    </x-filament::form>
</x-filament::page>
