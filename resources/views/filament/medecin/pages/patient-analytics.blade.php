<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold">{{ $this->record->name }}</h2>
            @php($profile = $this->record->patientProfile)
            @if($profile)
                <p>Date de naissance : {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d/m/Y') }}</p>
                <p>Genre : {{ $profile->gender }}</p>
                <p>Taille : {{ $profile->height }} cm</p>
                <p>Poids : {{ $profile->weight }} kg</p>
                <p>Antécédents médicaux : {{ $profile->medical_history }}</p>
                <p>Allergies : {{ $profile->allergies }}</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900">Dernières mesures de glycémie</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valeur</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Moment</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($this->glycemies as $g)
                    <tr>
                        <td class="px-4 py-2">{{ $g->date_mesure->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $g->heure_mesure }}</td>
                        <td class="px-4 py-2">{{ $g->valeur }} mmol/L</td>
                        <td class="px-4 py-2">{{ ucfirst($g->moment) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution glycémique</h3>
        </div>

        <div class="flex justify-end">
            <x-filament::button tag="a" href="{{ route('filament.doctor.pages.chat') }}">
                Contacter le patient
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
