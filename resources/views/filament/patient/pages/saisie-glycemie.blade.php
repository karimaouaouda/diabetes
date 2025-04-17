<x-filament-panels::page>
    {{-- Formulaire avec soumission vers la méthode save() --}}
    <x-filament-panels::form wire:submit="save">
        {{-- Affiche le formulaire --}}
        {{ $this->form }}

        {{-- Bouton d'enregistrement --}}
        <div class="flex justify-end mt-6">
            <x-filament::button
                type="submit"
                icon="heroicon-o-check-circle"
                size="md"
                color="primary"
            >
                Enregistrer 
            </x-filament::button>
        </div>
    </x-filament-panels::form>

    {{-- Notification de succès --}}
    @if (session('status'))
        <div class="p-4 mt-4 text-green-800 bg-green-50 rounded-lg">
            {{ session('status') }}
        </div>
    @endif
</x-filament-panels::page>
