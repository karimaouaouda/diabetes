<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\InformationTypeResource\Pages;
use App\Filament\Patient\Resources\InformationTypeResource\RelationManagers;
use App\Models\InformationType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InformationTypeResource extends Resource
{
    protected static ?string $model = InformationType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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
            'index' => Pages\ListInformationTypes::route('/'),
            'create' => Pages\CreateInformationType::route('/create'),
            'edit' => Pages\EditInformationType::route('/{record}/edit'),
        ];
    }
}
