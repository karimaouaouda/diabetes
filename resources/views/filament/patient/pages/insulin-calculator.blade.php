<x-filament::page>
    <div class="max-w-2xl mx-auto space-y-6">

        <x-filament::card>
            <form wire:submit.prevent="calculateDose" class="space-y-4">
                {{ $this->form }}


            </form>
        </x-filament:<!-- resources/views/patient/insulin-calculator.blade.php -->
        @extends('layouts.patient')

        @section('content')
        <div class="card">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Calculateur de Bolus</h5>
                    <div>
                        {{ now()->format('F j, Y') }} -
                        <span id="meal-time">
                            @if(now()->hour < 10)
                                Petit-déjeuner
                            @elseif(now()->hour < 12)
                                Matinée
                            @elseif(now()->hour < 14)
                                Déjeuner
                            @elseif(now()->hour < 18)
                                Après-midi
                            @elseif(now()->hour < 22)
                                Dîner
                            @else
                                Nuit
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="insulin-calculator-form">
                    @csrf

                    <!-- Sélection du moment du repas -->
                    <div class="form-group mb-3">
                        <label for="meal_type">Moment du repas</label>
                        <select class="form-control" id="meal_type" name="meal_type">
                            <option value="breakfast" {{ now()->hour < 10 ? 'selected' : '' }}>Petit-déjeuner</option>
                            <option value="morning" {{ now()->hour >= 10 && now()->hour < 12 ? 'selected' : '' }}>Matinée</option>
                            <option value="lunch" {{ now()->hour >= 12 && now()->hour < 14 ? 'selected' : '' }}>Déjeuner</option>
                            <option value="afternoon" {{ now()->hour >= 14 && now()->hour < 18 ? 'selected' : '' }}>Après-midi</option>
                            <option value="dinner" {{ now()->hour >= 18 && now()->hour < 22 ? 'selected' : '' }}>Dîner</option>
                            <option value="night" {{ now()->hour >= 22 ? 'selected' : '' }}>Nuit</option>
                        </select>
                    </div>

                    <!-- Section Glycémie -->
                    <div class="mb-4">
                        <h5>Glycémie actuelle</h5>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" class="form-control" id="blood_glucose" name="blood_glucose" placeholder="Entrez votre glycémie" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">mg/dL</span>
                                </div>
                            </div>
                        </div>

                        <div id="glucose-feedback" class="mt-2 d-none">
                            <div class="alert alert-info">
                                <p class="mb-1">Vous avez entré une glycémie de <span id="current-glucose"></span> mg/dL.</p>
                                <p class="mb-1">Cette valeur est <span id="glucose-status"></span> votre cible ({{ $settings->target_glucose ?? '100-120' }} mg/dL).</p>
                                <p class="mb-0" id="correction-info"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Insuline pour la compensation (correction) -->
                    <div class="mb-4 border-top pt-3">
                        <h5>Insuline pour la compensation (U.C.)</h5>

                        @if(isset($lastBolus) && $lastBolus && $lastBolus->created_at->diffInHours(now()) < 3)
                        <div class="alert alert-warning">
                            <strong>Attention :</strong> La dernière dose de bolus a été administrée il y a moins de 3 heures.
                            Une correction prudente s'applique.
                        </div>
                        @endif

                        <div class="form-group mb-2">
                            <label>Cible de glycémie: {{ $settings->target_glucose ?? '120' }} mg/dL</label>
                        </div>

                        <div class="form-group mb-2">
                            <label>Facteur de correction: 1 unité par {{ $settings->correction_factor ?? '50' }} mg/dL</label>
                        </div>

                        <div class="form-group">
                            <label for="correction_units">Nombre d'unités:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="correction_units" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">U</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Insuline pour le repas -->
                    <div class="mb-4 border-top pt-3">
                        <h5>Insuline pour le repas (U.M.)</h5>

                        <div class="form-group mb-3">
                            <label for="carbohydrates">Glucides du repas</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="Entrez les glucides" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label>Votre ratio: 1 unité par {{ $settings->carb_ratio ?? '10' }} grammes de glucides</label>
                        </div>

                        <div id="meal-info" class="d-none">
                            <p>Dose pour le repas: <span id="meal-dose"></span> Unités</p>
                        </div>

                        <div class="form-group">
                            <label for="meal_units">Nombre d'unités:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="meal_units" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">U</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Activité physique -->
                    <div class="mb-4 border-top pt-3">
                        <h5>Activité physique</h5>

                        <div class="form-group">
                            <select class="form-control" id="physical_activity" name="physical_activity">
                                <option value="none">Aucune activité physique</option>
                                <option value="light">Activité légère</option>
                                <option value="moderate">Activité modérée</option>
                                <option value="intense">Activité intense</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section Dose totale -->
                    <div class="mb-4 border-top pt-3">
                        <h5>Dose totale (Bolus)</h5>

                        <div id="total-info" class="mb-2">
                            <p>Dose totale: <span id="total-calculation"></span> = <span id="total-dose"></span> U</p>
                        </div>

                        <div class="form-group">
                            <label for="total_units">Nombre d'unités:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="total_units" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">U</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-danger" id="decline-btn">Refuser</button>
                        <button type="button" class="btn btn-danger" id="calculate-btn">Calculer</button>
                        <button type="button" class="btn btn-success d-none" id="accept-btn">Accepter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Paramètres -->
        <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="settingsModalLabel">Paramètres du calculateur</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('patient.insulin.settings') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="target_glucose">Glycémie cible (mg/dL)</label>
                                <input type="number" class="form-control" id="target_glucose" name="target_glucose"
                                    value="{{ $settings->target_glucose ?? 120 }}" min="70" max="180" required>
                            </div>
                            <div class="form-group">
                                <label for="correction_factor">Facteur de correction (mg/dL par unité)</label>
                                <input type="number" class="form-control" id="correction_factor" name="correction_factor"
                                    value="{{ $settings->correction_factor ?? 50 }}" min="1" max="100" required>
                                <small class="form-text text-muted">Combien de mg/dL une unité d'insuline fait baisser votre glycémie</small>
                            </div>
                            <div class="form-group">
                                <label for="carb_ratio">Ratio glucides (g par unité)</label>
                                <input type="number" class="form-control" id="carb_ratio" name="carb_ratio"
                                    value="{{ $settings->carb_ratio ?? 10 }}" min="1" max="50" required>
                                <small class="form-text text-muted">Combien de grammes de glucides une unité d'insuline couvre</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Historique -->
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="historyModalLabel">Historique des calculs</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Repas</th>
                                        <th>Glycémie</th>
                                        <th>Glucides</th>
                                        <th>Dose</th>
                                    </tr>
                                </thead>
                                <tbody id="history-table-body">
                                    <!-- Rempli par AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('scripts')
        <script>
            $(document).ready(function() {
                // Mettre à jour l'affichage du moment du repas
                $('#meal_type').change(function() {
                    const mealNames = {
                        'breakfast': 'Petit-déjeuner',
                        'morning': 'Matinée',
                        'lunch': 'Déjeuner',
                        'afternoon': 'Après-midi',
                        'dinner': 'Dîner',
                        'night': 'Nuit'
                    };
                    $('#meal-time').text(mealNames[$(this).val()]);
                });

                // Bouton de calcul
                $('#calculate-btn').click(function() {
                    const form = $('#insulin-calculator-form');

                    // Vérifier si les champs requis sont remplis
                    if (!form[0].checkValidity()) {
                        form.addClass('was-validated');
                        return;
                    }

                    // Collecter les données
                    const data = {
                        blood_glucose: $('#blood_glucose').val(),
                        carbohydrates: $('#carbohydrates').val(),
                        meal_type: $('#meal_type').val(),
                        physical_activity: $('#physical_activity').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    // Appel AJAX pour calculer la dose
                    $.ajax({
                        url: '{{ route("patient.insulin.calculate") }}',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            // Afficher les résultats
                            updateCalculationDisplay(response);

                            // Masquer le bouton de calcul et afficher le bouton d'acceptation
                            $('#calculate-btn').addClass('d-none');
                            $('#accept-btn').removeClass('d-none');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Une erreur est survenue lors du calcul. Veuillez réessayer.');
                        }
                    });
                });

                // Bouton d'acceptation
                $('#accept-btn').click(function() {
                    // Ici, vous pourriez enregistrer le fait que l'utilisateur a accepté la dose
                    // et éventuellement mettre à jour le carnet de glycémie

                    alert('Dose acceptée ! Les données ont été enregistrées dans votre carnet.');

                    // Réinitialiser le formulaire
                    $('#insulin-calculator-form')[0].reset();
                    $('#glucose-feedback').addClass('d-none');
                    $('#meal-info').addClass('d-none');
                    $('#correction_units').val('');
                    $('#meal_units').val('');
                    $('#total_units').val('');

                    // Masquer le bouton d'acceptation et afficher le bouton de calcul
                    $('#accept-btn').addClass('d-none');
                    $('#calculate-btn').removeClass('d-none');
                });

                // Bouton de refus
                $('#decline-btn').click(function() {
                    if (confirm('Êtes-vous sûr de vouloir annuler ce calcul ?')) {
                        // Réinitialiser le formulaire
                        $('#insulin-calculator-form')[0].reset();
                        $('#glucose-feedback').addClass('d-none');
                        $('#meal-info').addClass('d-none');
                        $('#correction_units').val('');
                        $('#meal_units').val('');
                        $('#total_units').val('');

                        // Masquer le bouton d'acceptation et afficher le bouton de calcul
                        $('#accept-btn').addClass('d-none');
                        $('#calculate-btn').removeClass('d-none');
                    }
                });

                // Fonction pour mettre à jour l'affichage des résultats de calcul
                function updateCalculationDisplay(data) {
                    // Mise à jour de l'affichage de la glycémie
                    $('#current-glucose').text(data.glucose);

                    if (data.glucose > data.targetGlucose) {
                        $('#glucose-status').text('au-dessus de');
                        $('#correction-info').text(`Correction à appliquer: ${data.correctionUnits} unités`);
                    } else if (data.glucose < data.targetGlucose) {
                        $('#glucose-status').text('en-dessous de');
                        $('#correction-info').text('Pas de correction nécessaire');
                    } else {
                        $('#glucose-status').text('égale à');
                        $('#correction-info').text('Pas de correction nécessaire');
                    }

                    $('#glucose-feedback').removeClass('d-none');

                    // Mise à jour des unités de correction
                    $('#correction_units').val(data.correctionUnits);

                    // Mise à jour des unités pour le repas
                    $('#meal-dose').text(data.mealUnits);
                    $('#meal-units').val(data.mealUnits);
                    $('#meal-info').removeClass('d-none');

                    // Mise à jour de la dose totale
                    $('#total-calculation').text(`${data.correctionUnits} + ${data.mealUnits}`);
                    $('#total-dose').text(data.totalDose);
                    $('#total_units').val(data.totalDose);
                }

                // Charger l'historique
                function loadHistory() {
                    $.ajax({
                        url: '{{ route("patient.insulin.history") }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const tbody = $('#history-table-body');
                            tbody.empty();

                            response.forEach(function(item) {
                                const mealNames = {
                                    'breakfast': 'Petit-déjeuner',
                                    'morning': 'Matinée',
                                    'lunch': 'Déjeuner',
                                    'afternoon': 'Après-midi',
                                    'dinner': 'Dîner',
                                    'night': 'Nuit'
                                };

                                const row = $('<tr>');
                                row.append($('<td>').text(new Date(item.created_at).toLocaleString()));
                                row.append($('<td>').text(mealNames[item.meal_type]));
                                row.append($('<td>').text(item.blood_glucose + ' mg/dL'));
                                row.append($('<td>').text(item.carbohydrates + ' g'));
                                row.append($('<td>').text(item.total_units + ' U'));

                                tbody.append(row);
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Une erreur est survenue lors du chargement de l\'historique.');
                        }
                    });
                }

                // Charger l'historique quand le modal est ouvert
                $('#historyModal').on('show.bs.modal', function() {
                    loadHistory();
                });
            });
        </script>
        @endsection:card>

        @if ($dose)
            <x-filament::card class="bg-green-100 border border-green-300">
                <div class="text-center text-2xl font-bold text-green-700">
                    الجرعة المطلوبة: {{ $dose }} وحدة
                </div>
            </x-filament::card>
        @endif

    </div>
</x-filament::page>
