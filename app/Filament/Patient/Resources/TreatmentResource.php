<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\TreatmentResource\Pages;
use App\Filament\Patient\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('doctor.name')
                ->label('Doctor')
                ->searchable(),
            Tables\Columns\TextColumn::make('note')
                ->label('Note')
                ->limit(40)
                ->wrap(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Prescribed At')
                ->dateTime('d/m/Y H:i'),
            Tables\Columns\TextColumn::make('medications_pivot_count')
                ->counts('medications_pivot')
                ->label('Medications Count'),
        ])
        ->filters([
            // Add filters if needed
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
        ])
        ->bulkActions([
            // No bulk actions for patients
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
