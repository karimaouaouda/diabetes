<?php

namespace App\Filament\Patient\Resources;

use App\Filament\Patient\Resources\TodoItemResource\Pages;
use App\Filament\Patient\Resources\TodoItemResource\RelationManagers;
use App\Models\TodoItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
class TodoItemResource extends Resource
{
    protected static ?string $model = TodoItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('task')->required(),
            DatePicker::make('due_date')->required(),
            Toggle::make('completed')
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
            'index' => Pages\ListTodoItems::route('/'),
            'create' => Pages\CreateTodoItem::route('/create'),
            'edit' => Pages\EditTodoItem::route('/{record}/edit'),
        ];
    }
}
