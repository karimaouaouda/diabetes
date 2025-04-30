<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsulinCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'current_bg' => 'required|numeric|min:0',
            'target_bg' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'icr' => 'required|numeric|min:0.1',
            'isf' => 'required|numeric|min:0.1',
            'iob' => 'numeric|min:0',
        ]);

        $calculation = $this->calculateDose($validated);

        return response()->json([
            'data' => $calculation,
            'message' => 'Calcul effectué avec succès'
        ]);
    }

    private function calculateDose($data)
    {
        $carbDose = $data['carbs'] / $data['icr'];
        $correction = ($data['current_bg'] - $data['target_bg']) / $data['isf'];
        $total = max(round($carbDose + $correction - $data['iob'], 1), 0);

        return [
            'dose' => $total,
            'components' => [
                'carbs' => round($carbDose, 1),
                'correction' => round($correction, 1),
                'iob' => $data['iob']
            ]
        ];
    }
}
