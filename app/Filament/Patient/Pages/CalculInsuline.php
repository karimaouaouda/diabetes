<?php
namespace App\Filament\Patient\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class CalculInsuline extends Page
{
    protected static string $view = 'filament.patient.pages.calcul-insuline';

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationLabel = 'Calculateur d\'Insuline';

    public $blood_glucose;
    public $target_glucose;
    public $carbohydrates;
    public $insulin_sensitivity;
    public $carb_ratio;
    public $iob = 0;
    public $result;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('blood_glucose')
                    ->label('Glycémie Actuelle (mg/dL)')
                    ->numeric()
                    ->required(),

                TextInput::make('target_glucose')
                    ->label('Cible Glycémique (mg/dL)')
                    ->numeric()
                    ->default(100)
                    ->required(),

                TextInput::make('carbohydrates')
                    ->label('Glucides (g)')
                    ->numeric()
                    ->required(),

                TextInput::make('insulin_sensitivity')
                    ->label('Sensibilité Insuline (mg/dL/unité)')
                    ->numeric()
                    ->default(50)
                    ->required(),

                TextInput::make('carb_ratio')
                    ->label('Ratio Glucides (g/unité)')
                    ->numeric()
                    ->default(10)
                    ->required(),

                TextInput::make('iob')
                    ->label('Insuline Active (IOB)')
                    ->numeric()
                    ->default(0),
            ]);

    }

    public function calculate()
    {
        $this->validate();

        $this->result = $this->calculateInsulinDose(
            $this->carbohydrates,
            $this->blood_glucose,
            $this->target_glucose,
            $this->insulin_sensitivity,
            $this->carb_ratio,
            $this->iob
        );
    }

    private function calculateInsulinDose($carbs, $currentBg, $targetBg, $isf, $icr, $iob)
    {
        $carbDose = $carbs / $icr;
        $correctionDose = ($currentBg - $targetBg) / $isf;
        $totalDose = $carbDose + $correctionDose - $iob;

        return [
            'total' => max(round($totalDose, 1), 0),
            'components' => [
                'carbs' => round($carbDose, 1),
                'correction' => round($correctionDose, 1),
                'iob' => round($iob, 1)
            ]
        ];
    }

    // Endpoint API
    public function apiCalculate(Request $request)
    {
        $data = $request->validate([
            'blood_glucose' => 'required|numeric',
            'target_glucose' => 'required|numeric',
            'carbohydrates' => 'required|numeric',
            'insulin_sensitivity' => 'required|numeric',
            'carb_ratio' => 'required|numeric',
            'iob' => 'sometimes|numeric'
        ]);

        return response()->json(
            $this->calculateInsulinDose(
                $data['carbohydrates'],
                $data['blood_glucose'],
                $data['target_glucose'],
                $data['insulin_sensitivity'],
                $data['carb_ratio'],
                $data['iob'] ?? 0
            )
        );
    }

}
