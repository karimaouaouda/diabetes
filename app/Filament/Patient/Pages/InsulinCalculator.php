<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Button;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use App\Models\InsulinCalculation;

class InsulinCalculator extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static string $view = 'filament.pages.insulin-calculator';
    protected static ?string $title = 'حاسبة جرعة الإنسولين';

    public $current_glucose;
    public $carbs;
    public $carb_ratio;
    public $insulin_sensitivity;
    public $target_glucose;
    public $dose;

    protected function getFormSchema(): array
    {
        return [
            Section::make('أدخل البيانات')
                ->schema([
                    TextInput::make('current_glucose')
                        ->label('مستوى السكر الحالي (mg/dL)')
                        ->numeric()
                        ->required(),

                    TextInput::make('carbs')
                        ->label('كمية الكربوهيدرات (غرام)')
                        ->numeric()
                        ->required(),

                    TextInput::make('carb_ratio')
                        ->label('حساس الكربوهيدرات (ICR)')
                        ->numeric()
                        ->required(),

                    TextInput::make('insulin_sensitivity')
                        ->label('معامل حساسية الإنسولين (ISF)')
                        ->numeric()
                        ->required(),

                    TextInput::make('target_glucose')
                        ->label('الهدف السكري (mg/dL)')
                        ->numeric()
                        ->required(),

                    //Button::make('احسب الجرعة')
                      //  ->action('calculateDose')
                        //->color('primary'),
                ]),
        ];
    }

    public function calculateDose()
{
    $meal_dose = $this->carbs / $this->carb_ratio;
    $correction_dose = ($this->current_glucose - $this->target_glucose) / $this->insulin_sensitivity;

    $this->dose = max(0, round($meal_dose + $correction_dose, 1));

    InsulinCalculation::create([
        'current_glucose' => $this->current_glucose,
        'carbs' => $this->carbs,
        'carb_ratio' => $this->carb_ratio,
        'insulin_sensitivity' => $this->insulin_sensitivity,
        'target_glucose' => $this->target_glucose,
        'calculated_dose' => $this->dose,
    ]);

    Notification::make()
        ->title("جرعة الإنسولين المحسوبة: {$this->dose} وحدة")
        ->success()
        ->send();
}

    public function mount(): void
    {
        $this->form->fill();
    }


}

