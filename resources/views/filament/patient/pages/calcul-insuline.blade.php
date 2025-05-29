<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculateur de Dose d'Insuline</title>
    <style>
        /* Variables CSS globales */
        :root {
            --primary-50: #eef2ff;
            --primary-100: #e0e7ff;
            --primary-200: #c7d2fe;
            --primary-300: #a5b4fc;
            --primary-400: #818cf8;
            --primary-500: #6366f1;
            --primary-600: #4f46e5;
            --primary-700: #4338ca;
            --primary-800: #3730a3;
            --primary-900: #312e81;
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --green-50: #f0fdf4;
            --green-100: #dcfce7;
            --green-600: #16a34a;
            --green-700: #15803d;
            --yellow-50: #fefce8;
            --yellow-100: #fef9c3;
            --yellow-600: #ca8a04;
            --yellow-700: #a16207;
            --purple-50: #faf5ff;
            --purple-100: #f3e8ff;
            --purple-600: #9333ea;
            --purple-700: #7e22ce;
            --orange-50: #fff7ed;
            --orange-400: #fb923c;
            --orange-700: #c2410c;
        }

        /* Styles de base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(to bottom right, var(--blue-50), var(--primary-50));
            color: #334155;
            min-height: 100vh;
            padding: 2rem 1rem;
            line-height: 1.5;
        }

        .container {
            max-width: 50rem;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--blue-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--primary-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-700);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Styles du formulaire */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-900);
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #374151;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: var(--primary-400);
            outline: 0;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .input-group {
            position: relative;
        }

        .input-group-append {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 500;
        }

        /* Bouton */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            border: 1px solid transparent;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(to right, var(--blue-600), var(--primary-600));
            border-color: var(--primary-600);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, var(--blue-700), var(--primary-700));
            border-color: var(--primary-700);
        }

        .btn-lg {
            padding: 0.875rem 1.75rem;
            font-size: 1.125rem;
            border-radius: 0.5rem;
        }

        .btn-icon {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Résultats */
        .result-card {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .result-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .result-box {
            padding: 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .result-box-title {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .result-box-value {
            font-size: 1.875rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .total-dose {
            background: linear-gradient(to right, var(--blue-50), var(--blue-100));
            color: var(--blue-700);
        }

        .total-dose .result-box-title {
            color: var(--blue-600);
        }

        .component-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .component-item:last-child {
            margin-bottom: 0;
        }

        .carbs-component {
            background: linear-gradient(to right, var(--green-50), var(--green-100));
        }

        .carbs-component .component-label {
            color: var(--green-600);
        }

        .carbs-component .component-value {
            color: var(--green-700);
        }

        .correction-component {
            background: linear-gradient(to right, var(--yellow-50), var(--yellow-100));
        }

        .correction-component .component-label {
            color: var(--yellow-600);
        }

        .correction-component .component-value {
            color: var(--yellow-700);
        }

        .iob-component {
            background: linear-gradient(to right, var(--purple-50), var(--purple-100));
        }

        .iob-component .component-label {
            color: var(--purple-600);
        }

        .iob-component .component-value {
            color: var(--purple-700);
        }

        .component-label {
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .component-value {
            font-weight: 700;
            font-size: 1rem;
        }

        /* Alerte */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-warning {
            background-color: var(--orange-50);
            border-left: 4px solid var(--orange-400);
            color: var(--orange-700);
        }

        .alert-icon {
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .alert-content {
            flex: 1;
            font-size: 0.9375rem;
        }

        /* Animation de chargement */
        .loading {
            display: none;
            text-align: center;
            padding: 1rem;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            width: 2.5rem;
            height: 2.5rem;
            border: 3px solid var(--primary-200);
            border-radius: 50%;
            border-top-color: var(--primary-600);
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Meal Selector Style */
        .meal-selector {
            display: inline-flex;
            align-items: center;
            margin-left: 1rem;
            position: relative;
        }

        .meal-select-button {
            background: linear-gradient(to right, var(--green-600), var(--blue-600));
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meal-select-button:hover {
            background: linear-gradient(to right, var(--green-700), var(--blue-700));
            transform: translateY(-1px);
        }

        .meal-select-button svg {
            width: 16px;
            height: 16px;
        }

        /* Header Flex */
        .header-content {
            display: flex;
            align-items: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Calculateur de Dose d'Insuline</h2>
                    <div class="meal-selector">
                        <a href="{{ url('/dashboard') }}" class="meal-select-button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6l3 0"></path>
                                <path d="M3 12l3 0"></path>
                                <path d="M3 18l3 0"></path>
                                <path d="M8 6l9 0"></path>
                                <path d="M8 12l9 0"></path>
                                <path d="M8 18l9 0"></path>
                            </svg>
                            Sélectionner un repas
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="insulinCalculator">
                    <div class="form-group">
                        <label for="carbAmount">Carbs (g)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="carbAmount" name="carbAmount" placeholder="Quantité de glucides" min="0" step="1" required>
                            <div class="input-group-append">g</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="carbRatio">Ratio Insuline/Carbs</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="carbRatio" name="carbRatio" placeholder="1:X" min="1" step="0.5" value="10" required>
                            <div class="input-group-append">g/u</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="currentBG">Glycémie actuelle</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="currentBG" name="currentBG" placeholder="Glycémie actuelle" min="0" step="1" required>
                            <div class="input-group-append">mg/dL</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="targetBG">Glycémie cible</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="targetBG" name="targetBG" placeholder="Glycémie cible" min="0" step="1" value="120" required>
                            <div class="input-group-append">mg/dL</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="isf">Facteur de sensibilité à l'insuline</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="isf" name="isf" placeholder="ISF" min="1" step="1" value="45" required>
                            <div class="input-group-append">mg/dL/u</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="iob">Insuline active (IOB)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="iob" name="iob" placeholder="Insuline déjà injectée" min="0" step="0.1" value="0">
                            <div class="input-group-append">unités</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="16" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="7" x2="12" y2="7"></line>
                            <line x1="8" y1="11" x2="12" y2="11"></line>
                            <line x1="8" y1="15" x2="12" y2="15"></line>
                        </svg>
                        Calculer la dose
                    </button>
                </form>

                <div class="loading" id="loadingIndicator">
                    <div class="spinner"></div>
                    <p>Calcul en cours...</p>
                </div>
            </div>
        </div>

        <div class="card result-card" id="resultCard" style="display: none;">
            <div class="card-header">
                <h2>Résultat du calcul</h2>
            </div>
            <div class="card-body">
                <div class="result-grid">
                    <div class="result-box total-dose">
                        <p class="result-box-title">Dose totale recommandée</p>
                        <p class="result-box-value" id="totalDose">0 unités</p>
                    </div>

                    <div>
                        <div class="component-item carbs-component">
                            <span class="component-label">Pour les carbs:</span>
                            <span class="component-value" id="carbsDose">0u</span>
                        </div>
                        <div class="component-item correction-component">
                            <span class="component-label">Correction glycémique:</span>
                            <span class="component-value" id="correctionDose">0u</span>
                        </div>
                        <div class="component-item iob-component">
                            <span class="component-label">Insuline active (IOB):</span>
                            <span class="component-value" id="iobDose">-0u</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-content">
                        Ce calcul est indicatif. Toujours vérifier avec votre médecin avant d'ajuster vos doses d'insuline.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('insulinCalculator');
            const resultCard = document.getElementById('resultCard');
            const loadingIndicator = document.getElementById('loadingIndicator');

            // Éléments d'affichage des résultats
            const totalDoseElement = document.getElementById('totalDose');
            const carbsDoseElement = document.getElementById('carbsDose');
            const correctionDoseElement = document.getElementById('correctionDose');
            const iobDoseElement = document.getElementById('iobDose');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Afficher l'indicateur de chargement
                loadingIndicator.classList.add('active');
                resultCard.style.display = 'none';

                // Récupérer les valeurs du formulaire
                const carbAmount = parseFloat(document.getElementById('carbAmount').value) || 0;
                const carbRatio = parseFloat(document.getElementById('carbRatio').value) || 10;
                const currentBG = parseFloat(document.getElementById('currentBG').value) || 0;
                const targetBG = parseFloat(document.getElementById('targetBG').value) || 120;
                const isf = parseFloat(document.getElementById('isf').value) || 45;
                const iob = parseFloat(document.getElementById('iob').value) || 0;

                // Simuler un délai de calcul (pour l'effet visuel)
                setTimeout(function() {
                    // Calcul de la dose pour les glucides
                    const carbDose = carbAmount / carbRatio;

                    // Calcul de la correction
                    let correction = 0;
                    if (currentBG > targetBG) {
                        correction = (currentBG - targetBG) / isf;
                    }

                    // Calcul de la dose totale
                    let totalDose = Math.max(0, carbDose + correction - iob);
                    totalDose = Math.round(totalDose * 10) / 10; // Arrondir à 1 décimale

                    // Afficher les résultats
                    totalDoseElement.textContent = totalDose + ' unités';
                    carbsDoseElement.textContent = carbDose.toFixed(1) + 'u';
                    correctionDoseElement.textContent = correction.toFixed(1) + 'u';
                    iobDoseElement.textContent = '-' + iob.toFixed(1) + 'u';

                    // Masquer l'indicateur de chargement et afficher les résultats
                    loadingIndicator.classList.remove('active');
                    resultCard.style.display = 'block';

                    // Faire défiler jusqu'aux résultats
                    resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 800);
            });
        });
    </script>
</body>
</html>
