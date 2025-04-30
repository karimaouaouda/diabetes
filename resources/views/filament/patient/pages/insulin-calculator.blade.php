<x-filament::page>
    <div class="max-w-2xl mx-auto space-y-6">

        <x-filament::card>
            <form wire:submit.prevent="calculateDose" class="space-y-4">
                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="submit" color="primary">
                        احسب الجرعة
                    </x-filament::button>
                </div>
            </form>
        </x-filament::card>

        @if ($dose)
            <x-filament::card class="bg-green-100 border border-green-300">
                <div class="text-center text-2xl font-bold text-green-700">
                    الجرعة المطلوبة: {{ $dose }} وحدة
                </div>
            </x-filament::card>
        @endif

    </div>
</x-filament::page>
