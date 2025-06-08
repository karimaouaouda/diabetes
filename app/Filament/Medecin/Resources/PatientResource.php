<?php

namespace App\Filament\Medecin\Resources;

use App\Enums\FollowingStatus;
use App\Filament\Medecin\Resources\PatientResource\Pages;
use App\Models\Following;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PatientResource extends Resource
{
    protected static ?string $model = Following::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Mes patients';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.name')->label('Patient')->searchable(),
                TextColumn::make('status')->label('Statut')->badge(),
            ])
            ->actions([
                Action::make('accept')
                    ->label('Accepter')
                    ->visible(fn (Following $record) => $record->status === FollowingStatus::PENDING)
                    ->action(fn (Following $record) => $record->update(['status' => FollowingStatus::ACCEPTED])),
                Action::make('reject')
                    ->label('Rejeter')
                    ->color('danger')
                    ->visible(fn (Following $record) => $record->status === FollowingStatus::PENDING)
                    ->action(fn (Following $record) => $record->update(['status' => FollowingStatus::REJECTED])),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return Following::query()->where('doctor_id', Auth::id())->with('patient');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
        ];
    }
}
