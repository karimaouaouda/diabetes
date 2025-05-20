<?php

namespace App\Filament\Patient\Resources;

use App\Enums\InformationOrder;
use App\Filament\Patient\Resources\InformationResource\Pages;
use App\Filament\Patient\Resources\InformationResource\RelationManagers;
use App\Models\Information;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Enums\informationtype;

class InformationResource extends Resource
{
    protected static ?string $model = Information::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('patient_id')
                    ->default(Auth::id()),
                Select::make('info_type_id')
                    ->required()
                    ->relationship('informationtype', 'name')
                    ->searchable(),

                Select::make('info_order')
                    ->required()
                    ->options(InformationOrder::toArray()),
                TextInput::make('value')
                    ->required()
                    ->minValue(0)
                    ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('informationType.name')
                    ->badge(),
                    //->array_searchable();
                TextColumn::make('value')
                    ->color(function(Information $record){
                        $min_value = $record->informationType->min_value;
                        $max_value = $record->informationType->max_value;


                    })
                    ->badge()
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
            'index' => Pages\ListInformation::route('/'),
            'create' => Pages\CreateInformation::route('/create'),
            'edit' => Pages\EditInformation::route('/{record}/edit'),
        ];
    }
}
