<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\DiabetesToolResource\Pages;
use App\Filament\Patient\Resources\DiabetesToolResource\RelationManagers;
use App\Models\DiabetesTool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Colors\Color;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiabetesToolResource extends Resource
{
    protected static ?string $model = DiabetesTool::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')->required()->label('Titre'),
            RichEditor::make('description')->required()->label('Description'),
            FileUpload::make('image')
                ->directory('diabetes-tools') // Dossier de stockage
                ->image()
                ->label('Image'),
            Select::make('category')
                ->options([
                    'surveillance' => 'Surveillance glycémique',
                    'alimentation' => 'Alimentation',
                    'activite' => 'Activité physique',
                ])
                ->required()
                ->label('Catégorie'),
        ]);
    }

    public static function table(Table $table): Table
    {

        return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image')->label('Image'),
            Tables\Columns\TextColumn::make('title')->label('Titre')
                ->searchable(),
            Tables\Columns\TextColumn::make('category')
            ->badge()
            ->color(function($state){
                if(strlen($state) < 5){
                    return Color::Red;
                }else{
                    return Color::Green;
                }
            })
            ->label('Catégorie'),
        ])->filters([
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
            'index' => Pages\ListDiabetesTools::route('/'),
            'create' => Pages\CreateDiabetesTool::route('/create'),
            'edit' => Pages\EditDiabetesTool::route('/{record}/edit'),
        ];
    }
}
