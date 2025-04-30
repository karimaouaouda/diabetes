<x-filament-panels::page>

</x-filament-pan@extends('filament::page')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Outils pour le diabète</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($tools as $tool)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img
                        src="{{ asset('storage/' . $tool->image) }}"
                        alt="{{ $tool->title }}"
                        class="w-full h-48 object-cover mb-4 rounded"
                    >
                    <h3 class="font-semibold text-lg">{{ $tool->title }}</h3>
                    <p class="text-gray-600 mt-2">{{ $tool->description }}</p>
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 mt-4 rounded-full text-sm">
                        {{ $tool->category }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsectionels::page>
