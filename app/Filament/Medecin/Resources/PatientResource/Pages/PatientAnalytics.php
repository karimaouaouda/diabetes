<?php

namespace App\Filament\Medecin\Resources\PatientResource\Pages;

use App\Filament\Medecin\Resources\PatientResource;
use App\Filament\Medecin\Widgets\PatientGlycemieChart;
use App\Filament\Medecin\Widgets\PatientInsulinChart;
use App\Filament\Patient\Widgets\HistoriqueGlycemieWidget;
use App\Filament\Patient\Widgets\HistoriqueInsulineWidget;
use App\Models\Glycemies;
use App\Models\DoseInsuline;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use function Filament\Support\is_app_url;

class PatientAnalytics extends ViewRecord implements HasForms, HasTable
{
    use InteractsWithForms, CanUseDatabaseTransactions, InteractsWithTable;

    protected static string $resource = PatientResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.medecin.pages.patient-analytics';

    protected static ?string $title = 'Analyse patient';

    protected static ?string $slug = 'patient-analytics';

    protected static bool $shouldRegisterNavigation = false;

    public array $settings = [];


    public function mount(int|string $record): void
    {
        $this->record = User::query()->findOrFail($record);

        $this->authorizeAccess();

        if (! $this->hasInfolist()) {
            $this->fillForm();
        }

    }



    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function getRecord(): Model
    {
        $record = $this->record
            ->insulineSettings()
            ->where('insulin_settings.doctor_id', auth()->id())->first();

        return $record ?: Filament::auth()->user()->insulineSettings()->create([
            'patient_id' => $this->record->getAttribute('id')
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('settings')
            ->operation('save')
            ->columns(2)
            ->schema([
                Section::make('Insuline Settings')
                    ->collapsible()
                    ->collapsed()
                    ->description('insuline settings will help patient calculate correctly the insuline dose')
                    ->model($this->getRecord())
                    ->schema([
                        Hidden::make('patient_id')
                            ->default($this->record->getAttribute('id')),
                        TextInput::make('target_glucose')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(200),
                        TextInput::make('correction_factor')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(80),
                        TextInput::make('carb_ratio')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50),
                        TextInput::make('danger_max_bound')
                            ->required()
                            ->numeric()
                            ->minValue(100)
                            ->maxValue(150),
                        TextInput::make('danger_min_bound')
                            ->required()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(90),

                        Actions::make([
                            Actions\Action::make('save settings')
                                ->action('save')
                                ->color(Color::Green)
                        ])
                    ])
            ]);
    }

    /**
     * @throws \Throwable
     */
    public function save(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            $this->getRecord()->update($data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (\Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->commitDatabaseTransaction();

        $this->getSavedNotification()?->send();
    }


    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::pages/auth/edit-profile.notifications.saved.title');
    }
    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }
    public function getFormStatePath(): ?string
    {
        return 'settings';
    }


    protected function getHeaderWidgets(): array
    {
        return [];
    }



    public function getModel(): string
    {
        return User::class;
    }

    public function getGlycemiesProperty()
    {
        return Glycemies::where('patient_id', $this->record->id)
            ->orderByDesc('date_mesure')
            ->orderByDesc('heure_mesure')
            ->take(10)
            ->get();
    }




    public function getInsulinDosesProperty()
    {
        return DoseInsuline::where('patient_id', $this->record->id)
            ->orderByDesc('date_heure')
            ->take(10)
            ->get();
    }

    public function getTableQuery(): Builder | Relation | null
    {
        return Glycemies::query()->where('patient_id', $this->record->getAttribute('id'));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('id')
                    ->badge()
                    ->prefix("#")
            ]);
    }

}
