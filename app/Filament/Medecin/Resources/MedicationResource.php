<?php

namespace App\Filament\Medecin\Resources;

use App\Filament\Medecin\Resources\MedicationResource\Pages;
use App\Filament\Medecin\Resources\MedicationResource\RelationManagers;
use App\Models\Medication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MedicationResource extends Resource
{
    protected static ?string $model = Medication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('doctor_id')
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('name')
                    ->placeholder('medication name')
                    ->required()
                    ->minLength(5)
                    ->maxLength(255),
                Forms\Components\TextInput::make('dose')
                    ->numeric()
                    ->placeholder('medication dose')
                    ->minValue(0)
                    ->suffix('mg|pcs')
                    ->maxValue(1000),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->placeholder('medication description')
                    ->minLength(5)
                    ->columnSpan(2)
                    ->maxLength(255),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->prefix("#"),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description')
                    ->words(5)
                    ->tooltip(fn($state) => $state),
                Tables\Columns\TextColumn::make('dose')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->badge()
                    ->color(Color::Blue)
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
            'index' => Pages\ListMedications::route('/'),
            'create' => Pages\CreateMedication::route('/create'),
            'edit' => Pages\EditMedication::route('/{record}/edit'),
        ];
    }
}
