<?php

namespace App\Filament\Patient\Resources\TreatmentResource\Pages;

use App\Filament\Patient\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\HtmlString;

class ViewTreatment extends ViewRecord
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Treatments')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Treatment Information')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('doctor.name')
                                    ->label('Prescribed by')
                                    ->icon('heroicon-o-user')
                                    ->weight(FontWeight::Bold)
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Prescribed on')
                                    ->dateTime()
                                    ->icon('heroicon-o-calendar')
                                    ->color('gray'),
                            ]),
                        Infolists\Components\TextEntry::make('note')
                            ->label('Treatment Notes')
                            ->placeholder('No notes provided')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (?string $state): HtmlString =>
                                new HtmlString(nl2br(e($state ?: 'No specific notes provided by the doctor.')))
                            ),
                    ]),

                Infolists\Components\Section::make('Prescribed Medications')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('medications_pivot')
                            ->label('')
                            ->schema([
                                Infolists\Components\Grid::make(3)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('medication.name')
                                            ->label('Medication')
                                            ->weight(FontWeight::Bold)
                                            ->color('primary')
                                            ->icon('heroicon-o-beaker'),
                                        Infolists\Components\TextEntry::make('start_date')
                                            ->label('Start Date')
                                            ->dateTime()
                                            ->icon('heroicon-o-play')
                                            ->color('success'),
                                        Infolists\Components\TextEntry::make('end_date')
                                            ->label('End Date')
                                            ->dateTime()
                                            ->placeholder('Ongoing')
                                            ->icon('heroicon-o-stop')
                                            ->color('warning'),
                                    ]),
                                Infolists\Components\TextEntry::make('times')
                                    ->label('When to take')
                                    ->columnSpanFull()
                                    ->formatStateUsing(function ($state) {
                                        if (!$state || !is_array($state)) {
                                            return 'No specific times provided';
                                        }

                                        $times = collect($state)->map(function ($time) {
                                            if (is_array($time) && isset($time['time'])) {
                                                return $time['time'];
                                            }
                                            return $time;
                                        })->filter()->unique();

                                        if ($times->isEmpty()) {
                                            return 'No specific times provided';
                                        }

                                        return $times->join(', ');
                                    })
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-o-clock'),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->getStateUsing(function ($record): string {
                                        $now = now();
                                        $startDate = $record->start_date ? \Carbon\Carbon::parse($record->start_date) : null;
                                        $endDate = $record->end_date ? \Carbon\Carbon::parse($record->end_date) : null;

                                        if (!$startDate) {
                                            return 'Unknown';
                                        }

                                        if ($startDate->isFuture()) {
                                            return 'Upcoming';
                                        }

                                        if (!$endDate || $endDate->isFuture()) {
                                            return 'Active';
                                        }

                                        return 'Completed';
                                    })
                                    ->badge()
                                    ->colors([
                                        'success' => 'Active',
                                        'warning' => 'Upcoming',
                                        'secondary' => 'Completed',
                                        'danger' => 'Unknown',
                                    ]),
                                Infolists\Components\Separator::make()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull()
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->persistCollapsed(),

                Infolists\Components\Section::make('Treatment Summary')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('total_medications')
                                    ->label('Total Medications')
                                    ->getStateUsing(fn ($record) => $record->medications_pivot->count())
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-o-beaker'),
                                Infolists\Components\TextEntry::make('active_medications')
                                    ->label('Active Medications')
                                    ->getStateUsing(function ($record): int {
                                        $now = now();
                                        return $record->medications_pivot->filter(function ($medication) use ($now) {
                                            $startDate = $medication->start_date ? \Carbon\Carbon::parse($medication->start_date) : null;
                                            $endDate = $medication->end_date ? \Carbon\Carbon::parse($medication->end_date) : null;

                                            if (!$startDate) return false;

                                            return $startDate->isPast() && (!$endDate || $endDate->isFuture());
                                        })->count();
                                    })
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-check-circle'),
                                Infolists\Components\TextEntry::make('completed_medications')
                                    ->label('Completed Medications')
                                    ->getStateUsing(function ($record): int {
                                        $now = now();
                                        return $record->medications_pivot->filter(function ($medication) use ($now) {
                                            $endDate = $medication->end_date ? \Carbon\Carbon::parse($medication->end_date) : null;
                                            return $endDate && $endDate->isPast();
                                        })->count();
                                    })
                                    ->badge()
                                    ->color('secondary')
                                    ->icon('heroicon-o-archive-box'),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    protected function getTitle(): string
    {
        return 'Treatment Details';
    }

    protected function getSubheading(): ?string
    {
        return 'View your prescribed treatment and medication schedule';
    }
}
