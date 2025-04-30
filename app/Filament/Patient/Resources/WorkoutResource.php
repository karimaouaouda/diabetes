<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\WorkoutResource\Pages;
use App\Filament\Patient\Resources\WorkoutResource\RelationManagers;
use App\Models\Workout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkoutResource extends Resource
{
    protected static ?string $model = Workout::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')->required(),
            RichEditor::make('description')->required(),
            TextInput::make('duration')->numeric()->required(),
            Select::make('difficulty')
                ->options(['beginner' => 'Débutant', 'intermediate' => 'Intermédiaire', 'advanced' => 'Avancé']),
            Select::make('category')
                ->options(['cardio' => 'Cardio', 'strength' => 'Force', 'flexibility' => 'Flexibilité'])
        ]);
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
            'index' => Pages\ListWorkouts::route('/'),
            'create' => Pages\CreateWorkout::route('/create'),
            'edit' => Pages\EditWorkout::route('/{record}/edit'),
        ];
    }
}
