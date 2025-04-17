<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Sélection du patient --}}
        <div class="bg-white rounded-lg shadow p-6">
            {{ $this->form }}
        </div>

        {{-- Tableau des résultats --}}
        @if($this->patientId)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        Historique glycémique de {{ Patient::find($this->patientId)->name }}
                    </h3>
                </div>

                {{ $this->table }}
            </div>

            {{-- Graphique --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution glycémique</h3>
                <canvas id="glycemieChart" height="100"></canvas>
            </div>

            @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('livewire:load', function () {
                        const ctx = document.getElementById('glycemieChart').getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($this->getGlycemieDates()) !!},
                                datasets: [{
                                    label: 'Valeur glycémique (mmol/L)',
                                    data: {!! json_encode($this->getGlycemieValues()) !!},
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    tension: 0.3,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        suggestedMin: 2,
                                        suggestedMax: 10
                                    }
                                }
                            }
                        });

                        Livewire.on('patientChanged', () => {
                            chart.data.labels = {!! json_encode($this->getGlycemieDates()) !!};
                            chart.data.datasets[0].data = {!! json_encode($this->getGlycemieValues()) !!};
                            chart.update();
                        });
                    });
                </script>
            @endpush
        @endif
    </div>
</x-filament-panels::page>
