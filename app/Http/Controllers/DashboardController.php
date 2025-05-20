<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Glycemie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // In your DashboardController.php
public function index()
{
    // Get current user/patient
    $patient = auth()->user();

    // Get glycemic records for the last 30 days
    $startDate = now()->subDays(30);
    $glycemieData = Glycemie::where('patient_id', $patient->id)
                          ->where('date', '>=', $startDate)
                          ->orderBy('date')
                          ->orderBy('heure')
                          ->get();

    // Format data for chart
    $chartData = $this->formatChartData($glycemieData);

    return view('dashboard', compact('patient', 'chartData'));
}

private function formatChartData($glycemieData)
{
    // Format data for chart display
    $formattedData = [];

    foreach ($glycemieData as $record) {
        $dateTime = Carbon::parse($record->date . ' ' . $record->heure);
        $formattedDate = $dateTime->format('Y-m-d');

        $formattedData[] = [
            'date' => $formattedDate,
            'value' => $record->valeur,
            'insulin' => $record->dose_insuline,
        ];
    }

    return $formattedData;
}
    // In your controller that handles the form submission (likely GlycemieController.php)
public function store(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'valeur' => 'required|numeric',
        'dose_insuline' => 'nullable|numeric',
        'date' => 'required|date',
        'heure' => 'required',
        'moment' => 'required',
        'commentaire' => 'nullable|string',
    ]);

    // Create a new glycemic record
    $glycemie = new Glycemie();
    $glycemie->valeur = $validated['valeur'];
    $glycemie->dose_insuline = $validated['dose_insuline'];
    $glycemie->date = $validated['date'];
    $glycemie->heure = $validated['heure'];
    $glycemie->moment = $validated['moment'];
    $glycemie->commentaire = $validated['commentaire'];
    $glycemie->patient_id = auth()->user()->id; // Assuming patient is logged in

    $glycemie->save();

    // Redirect to dashboard with success message
    return redirect()->route('dashboard')->with('success', 'Mesure de glycémie enregistrée avec succès');
}

    public function destroy(Glycemie $glycemie)
    {
        // Vérifier si l'utilisateur authentifié est le propriétaire de la glycémie
        if ($glycemie->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Supprimer la glycémie
        $glycemie->delete();

        return redirect()->route('dashboard')->with('success', 'Mesure de glycémie supprimée avec succès');
    }
    public function edit(Glycemie $glycemie)
    {
        // Vérifier si l'utilisateur authentifié est le propriétaire de la glycémie
        if ($glycemie->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('patient.edit_glycemie', compact('glycemie'));
    }
    public function update(Request $request, Glycemie $glycemie)
    {
        // Vérifier si l'utilisateur authentifié est le propriétaire de la glycémie
        if ($glycemie->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Valider les données
        $validated = $request->validate([
            'valeur' => 'required|numeric',
            'dose_insuline' => 'nullable|numeric',
            'date' => 'required|date',
            'heure' => 'required',
            'moment' => 'required',
            'commentaire' => 'nullable|string',
        ]);

        // Mettre à jour la glycémie
        $glycemie->update($validated);

        return redirect()->route('dashboard')->with('success', 'Mesure de glycémie mise à jour avec succès');
    }
    public function show(Glycemie $glycemie)
    {
        // Vérifier si l'utilisateur authentifié est le propriétaire de la glycémie
        if ($glycemie->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('patient.show_glycemie', compact('glycemie'));
    }
    public function create()
    {
        return view('patient.create_glycemie');
    }
}
