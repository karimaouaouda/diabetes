<x-filament-panels::page>
    <div class="flex justify-around flex-wrap w-full">
        @for($i = 0; $i < 5; $i++)
            <x-meal-card :meall="null" />
        @endfor
    </div>
</x-filament-panels::page>
