<?php

namespace App\Filament\Medecin\Resources;

use App\Enums\MedicationTime;
use App\Filament\Medecin\Resources\TreatmentResource\Pages;
use App\Filament\Medecin\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Treatment Basic Information')
                        ->schema([
                            Forms\Components\Hidden::make('doctor_id')
                                ->default(Auth::id()),
                            Forms\Components\Select::make('patient_id')
                                ->preload()
                                ->prefixIcon('heroicon-o-user')
                                ->options(Auth::user()->patients()->pluck('users.name', 'users.id')->toArray()),
                            Forms\Components\Textarea::make('note')
                                ->placeholder('note'),
                        ])->columns(1),
                    Forms\Components\Wizard\Step::make('Medications')
                        ->schema([
                            Forms\Components\Repeater::make('medications')
                                ->label('Medications')
                                ->relationship('medications_pivot')
                                ->schema([
                                    Forms\Components\Select::make('medication_id')
                                        ->options(Auth::user()->medications()->pluck('name', 'id')->toArray())
                                        ->required(),
                                    Forms\Components\DateTimePicker::make('start_date')
                                        ->placeholder('start date')
                                        ->minDate(now())
                                        ->required(),
                                    Forms\Components\DateTimePicker::make('end_date')
                                        ->minDate(now()->addWeek())
                                        ->placeholder('end date'),
                                    Forms\Components\Repeater::make('times')
                                        ->schema([
                                            Forms\Components\Select::make('time')
                                                ->required()
                                                ->options(MedicationTime::toArray())
                                        ]),
                                ])
                        ])
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
