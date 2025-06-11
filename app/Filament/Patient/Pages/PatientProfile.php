<?php

namespace App\Filament\Patient\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile;
use Filament\Support\Colors\Color;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use JetBrains\PhpStorm\NoReturn;
use function Filament\Support\is_app_url;

class PatientProfile extends EditProfile
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.patient.pages.patient-profile';



    public array $basic_informations = [];

    public array $password_informations = [];

    public array $body_informations = [];

    public function mount(): void
    {
        $patient = Filament::auth()->user();
        $profile = $patient->patientProfile;


        $this->callHook('beforeFill');

        $this->updateBasicInformationsForm->fill($patient->attributesToArray());
        $this->updateBodyInformationsForm->fill($profile?->attributesToArray() ?? []);
        $this->callHook('afterFill');

    }

    public function updateBasicInformationsForm(Form $form): Form
    {
        return $form
            ->statePath('basic_informations')
            ->model(Filament::auth()->user())
            ->schema([
                Section::make('personal informations')
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-o-user')
                    ->description('your personal information for profile managment')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->minDate(now()->subDecades(7)),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female'
                            ])
                            ->required(),
                        Actions::make([
                            Action::make('save')
                                ->action('handleUpdateBasicInformationsForm')
                        ])
                    ])
            ])
            ->operation('handleUpdateBasicInformationsForm');
    }

    public function updatePasswordForm(Form $form): Form
    {
        return $form
            ->operation('handleUpdatePasswordForm')
            ->statePath('password_informations')
            ->schema([
                Section::make('update password')
                    ->collapsed()
                    ->collapsible()
                    ->description('update your password informations')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Actions::make([
                            Action::make('save')
                                ->color(Color::Green)
                                ->action('handleUpdatePasswordForm()')
                        ])
                    ])
        ]);
    }

    public function updateBodyInformationsForm(Form $form): Form
    {
        return $form
            ->operation('handleUpdateBodyInformation')
            ->statePath('body_informations')
            ->schema([
                Section::make('body informations')
                    ->description('health informations help doctor to give u right measures')
                    ->icon('heroicon-o-heart')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        TextInput::make('weight')
                            ->label('Weight')
                            ->default(60)
                            ->required()
                            ->numeric()
                            ->suffix('Kg')
                            ->minValue(20),
                        TextInput::make('height')
                            ->default(140)
                            ->required()
                            ->numeric()
                            ->minValue(100)
                            ->suffix('cm'),
                        Select::make('blood_type')
                            ->options([
                                'A+' => 'A+',
                                'B+' => 'B+',
                                'A-' => 'A-',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-'
                            ])
                            ->required()
                            ->default('B+'),
                        Repeater::make('meals')
                            ->reorderable(false)
                            ->deletable(false)
                            ->schema([
                                TimePicker::make('breakfast')
                                    ->seconds(false)
                                    ->required(),
                                TimePicker::make('lunch')
                                    ->seconds(false)
                                    ->required(),
                                TimePicker::make('dinner')
                                    ->seconds(false)
                                    ->required(),

                            ])->maxItems(1)
                            ->grow(false),
                        Actions::make([
                            Action::make('save')
                                ->color(Color::Green)
                                ->action('handleUpdateBodyInformation')
                        ])
                    ])
            ]);
    }

    public function getForms(): array
    {
        return [
            'form' => $this->updateBodyInformationsForm(Form::make($this)),
            'updateBasicInformationsForm' => $this->updateBasicInformationsForm(Form::make($this)),
            'updatePasswordForm' => $this->updatePasswordForm(Form::make($this)),
            'updateBodyInformationsForm' => $this->updateBodyInformationsForm(Form::make($this))
        ];
    }





    #[NoReturn]
    public function handleUpdateBasicInformationsForm(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->updateBasicInformationsForm->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            Filament::auth()->user()->update($data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->commitDatabaseTransaction();

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
        }
    }

    #[NoReturn]
    public function handleUpdatePasswordForm(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->updatePasswordForm->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            Filament::auth()->user()->update($data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->commitDatabaseTransaction();

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->password_informations['password'] = null;
        $this->password_informations['passwordConfirmation'] = null;

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
        }
    }

    #[NoReturn]
    public function handleUpdateBodyInformation(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = $this->updateBodyInformationsForm->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            Filament::auth()->user()->patientProfile()->update($data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->commitDatabaseTransaction();

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
        }
    }
}
