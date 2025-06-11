<x-filament-panels::page>
    @vite('resources/css/app.css')
    <div class="flex justify-around flex-wrap w-full gap-2">
        @for($i = 0; $i < 5; $i++)
            <x-meal-card :meall="null" />
        @endfor
    </div>
</x-filament-panels::page>
