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

    public static function getEloquentQuery(): Builder
    {
        return Treatment::query()->where('doctor_id', auth()->id());
    }

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

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('id')
                    ->label('ID')
                    ->color('blue')
                    ->prefix('#'),
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Target Patient Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date/Time of Creation')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('medications_count')
                    ->label('Medications Count')
                    ->counts('medications')
                    ->sortable(),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->multiple()
                    ->options(fn() => Auth::user()->patients()->pluck('users.name', 'users.id')->toArray())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('viewMedications')
                    ->label('View Medications')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn(Treatment $record) => 'Medications for Treatment #' . $record->id)
                    ->modal()
                    ->modalContent(function(Treatment $record){
                        return view('filament.medecin.treatment.view-medications', [
                            'medications' => $record->medications,
                        ]);
                    })
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
