<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Medications for Treatment</h1>

    @if($medications->isEmpty())
        <p class="text-gray-600">No medications available for this treatment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($medications as $medication)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-bold text-blue-600">{{ $medication->name }}</h2>
                    <p class="text-gray-700 mt-2">
                        <strong>Dose:</strong> {{ $medication->dose }} mg
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong>Description:</strong> {{ $medication->description }}
                    </p>
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-800">Schedule:</h3>
                        <ul class="list-disc list-inside mt-2 text-gray-700">
                            @foreach(json_decode($medication->pivot->times, true) as $time)
                                <li>{{ $time['time'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="text-gray-700 mt-4">
                        <strong>Start
                            Date:</strong> {{ \Carbon\Carbon::parse($medication->pivot->start_date)->format('M d, Y') }}
                    </p>
                    <p class="text-gray-700">
                        <strong>End
                            Date:</strong> {{ \Carbon\Carbon::parse($medication->pivot->end_date)->format('M d, Y') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>
