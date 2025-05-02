<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\InsulinEntryResource\Pages;
use App\Filament\Patient\Resources\InsulinEntryResource\RelationManagers;
use App\Models\InsulinEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InsulinEntryResource extends Resource
{
    protected static ?string $model = InsulinEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\DatePicker::make('date')
                ->default(now())
                ->required(),
            Forms\Components\TextInput::make('blood_glucose')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('carbs')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('date'),
            Tables\Columns\TextColumn::make('blood_glucose'),
            Tables\Columns\TextColumn::make('carbs'),
            Tables\Columns\TextColumn::make('total_bolus'),
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
            'index' => Pages\ListInsulinEntries::route('/'),
            'create' => Pages\CreateInsulinEntry::route('/create'),
            'edit' => Pages\EditInsulinEntry::route('/{record}/edit'),
        ];
    }
}
