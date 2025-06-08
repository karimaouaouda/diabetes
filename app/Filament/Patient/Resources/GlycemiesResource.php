<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\GlycemiesResource\Pages;
use App\Filament\Patient\Resources\GlycemiesResource\RelationManagers;
use App\Models\Glycemies;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GlycemiesResource extends Resource
{
    protected static ?string $model = Glycemies::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            'index' => Pages\ListGlycemies::route('/'),
            'create' => Pages\CreateGlycemies::route('/create'),
            'edit' => Pages\EditGlycemies::route('/{record}/edit'),
        ];
    }
}
