<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InsulinCalculation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InsulinCalculatorController extends Controller
{
    /**
     * Affiche la page du calculateur d'insuline
     */
    public function index()
    {
        // Récupérer les paramètres de l'utilisateur
        $user = Auth::user();
        $settings = $user->insulinSettings;

        // Récupérer la dernière dose de bolus
        $lastBolus = InsulinCalculation::where('user_id', $user->id)
            ->where('created_at', '>', Carbon::now()->subHours(3))
            ->orderBy('created_at', 'desc')
            ->first();

        return view('patient.insulin-calculator', [
            'settings' => $settings,
            'lastBolus' => $lastBolus,
        ]);
    }

    /**
     * Calcule la dose d'insuline en fonction des paramètres
     */
    public function calculate(Request $request)
    {
        // Valider les données d'entrée
        $validated = $request->validate([
            'blood_glucose' => 'required|numeric|min:0',
            'carbohydrates' => 'required|numeric|min:0',
            'meal_type' => 'required|string|in:breakfast,morning,lunch,afternoon,dinner,night',
            'physical_activity' => 'nullable|string|in:none,light,moderate,intense',
        ]);

        $user = Auth::user();
        $settings = $user->insulinSettings;

        // Si les paramètres n'existent pas, utiliser des valeurs par défaut
        $targetGlucose = $settings->target_glucose ?? 120;
        $correctionFactor = $settings->correction_factor ?? 50;
        $carbRatio = $settings->carb_ratio ?? 10;

        // Calculer la correction pour la glycémie
        $correctionUnits = $this->calculateCorrection(
            $validated['blood_glucose'],
            $targetGlucose,
            $correctionFactor
        );

        // Calculer l'insuline pour les glucides
        $mealUnits = $this->calculateMealInsulin(
            $validated['carbohydrates'],
            $carbRatio,
            $validated['meal_type']
        );

        // Ajuster en fonction de l'activité physique
        $activityAdjustment = $this->adjustForActivity($validated['physical_activity'] ?? 'none');

        // Calculer la dose totale
        $totalDose = max(0, $correctionUnits + $mealUnits) * $activityAdjustment;

        // Arrondir à la précision souhaitée (0.5 unités par exemple)
        $totalDose = round($totalDose * 2) / 2;

        // Enregistrer le calcul dans l'historique
        $calculation = new InsulinCalculation([
            'user_id' => $user->id,
            'blood_glucose' => $validated['blood_glucose'],
            'carbohydrates' => $validated['carbohydrates'],
            'meal_type' => $validated['meal_type'],
            'correction_units' => $correctionUnits,
            'meal_units' => $mealUnits,
            'total_units' => $totalDose,
            'physical_activity' => $validated['physical_activity'] ?? 'none',
        ]);
        $calculation->save();

        // Retourner les résultats
        return response()->json([
            'correctionUnits' => round($correctionUnits, 1),
            'mealUnits' => round($mealUnits, 1),
            'totalDose' => $totalDose,
            'glucose' => $validated['blood_glucose'],
            'targetGlucose' => $targetGlucose,
            'hasPreviousDose' => $this->hasPreviousDose(),
        ]);
    }

    /**
     * Récupère l'historique des calculs d'insuline
     */
    public function getHistory()
    {
        $user = Auth::user();

        $history = InsulinCalculation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(50)  // Limiter aux 50 derniers calculs
            ->get();

        return response()->json($history);
    }

    /**
     * Calcule la correction d'insuline basée sur la glycémie
     */
    private function calculateCorrection($currentGlucose, $targetGlucose, $correctionFactor)
    {
        // Si la glycémie est inférieure à la cible, pas de correction
        if ($currentGlucose <= $targetGlucose) {
            return 0;
        }

        // Calculer la différence et appliquer le facteur de correction
        $difference = $currentGlucose - $targetGlucose;
        return $difference / $correctionFactor;
    }

    /**
     * Calcule l'insuline nécessaire pour les glucides
     */
    private function calculateMealInsulin($carbs, $carbRatio, $mealType)
    {
        // Ajuster le ratio de glucides en fonction du type de repas
        $adjustedRatio = $this->adjustRatioByMealType($carbRatio, $mealType);

        // Calculer les unités pour les glucides
        return $carbs / $adjustedRatio;
    }

    /**
     * Ajuste le ratio en fonction du moment de la journée
     */
    private function adjustRatioByMealType($baseRatio, $mealType)
    {
        $adjustments = [
            'breakfast' => 0.9,    // Plus sensible à l'insuline le matin
            'morning' => 1.0,
            'lunch' => 1.0,
            'afternoon' => 1.1,
            'dinner' => 1.0,
            'night' => 1.2,        // Moins sensible à l'insuline la nuit
        ];

        return $baseRatio * ($adjustments[$mealType] ?? 1.0);
    }

    /**
     * Ajuste la dose en fonction de l'activité physique
     */
    private function adjustForActivity($activityLevel)
    {
        $adjustments = [
            'none' => 1.0,
            'light' => 0.9,
            'moderate' => 0.8,
            'intense' => 0.7,
        ];

        return $adjustments[$activityLevel] ?? 1.0;
    }

    /**
     * Vérifie si l'utilisateur a eu une dose dans les dernières 3 heures
     */
    private function hasPreviousDose()
    {
        $user = Auth::user();

        return InsulinCalculation::where('user_id', $user->id)
            ->where('created_at', '>', Carbon::now()->subHours(3))
            ->exists();
    }

    /**
     * Enregistre les paramètres du calculateur d'insuline
     */
    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'target_glucose' => 'required|numeric|min:70|max:180',
            'correction_factor' => 'required|numeric|min:1|max:100',
            'carb_ratio' => 'required|numeric|min:1|max:50',
        ]);

        $user = Auth::user();
        $user->insulinSettings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->back()->with('success', 'Paramètres enregistrés avec succès');
    }
}
