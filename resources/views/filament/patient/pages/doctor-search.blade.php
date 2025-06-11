<x-filament-panels::page xmlns:x-filament="http://www.w3.org/1999/html">
    @vite('resources/css/app.css')
    <div class="space-y-4">
        <x-filament::input.wrapper>
            <x-slot name="suffixIcon">
                <x-filament::loading-indicator wire:loading  />
                <x-heroicon-o-magnifying-glass wire:loading.remove/>
            </x-slot>
            <x-filament::input wire:model.live.debounce.500ms="search" type="text" placeholder="Rechercher un médecin..."/>
        </x-filament::input.wrapper>
        <p>
            results for : {{$search}}
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->doctors as $doctor)
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden">
                        <img src="{{ $doctor->avatar_url }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="mt-2 font-medium">{{ $doctor->name }}</div>
                    <div class="text-sm text-gray-500">{{ $doctor->email }}</div>
                    <x-filament::button wire:click="requestFollow({{ $doctor->id }})">
                        follow
                    </x-filament::button>
                </div>
            @endforeach
        </div>

        {{ $this->doctors->links() }}
    </div>
</x-filament-panels::page>
