<?php

namespace App\Filament\Patient\Pages;

use App\Enums\FollowingStatus;
use App\Models\Following;
use App\Models\User;
use App\Enums\UserRoles;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class DoctorSearch extends Page
{
    use WithPagination;

    protected static ?string $navigationLabel = 'Trouver un médecin';

    protected static ?string $title = 'Recherche de médecins';
    protected static ?string $slug = 'doctor-search';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.patient.pages.doctor-search';

    public function mount(){
        if( Following::where('patient_id', Auth::id())->exists() ){
            $this->notify('danger', 'Vous avez déjà une demande en cours ou un médecin.');
            $this->dispatch('cannot-access');
        }
    }

    public string $search = '';

    public function getDoctorsProperty()
    {
        return User::where('role', UserRoles::DOCTOR)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })->paginate(8);
    }

    #[On('cannot-access')]
    public function back(){
        $this->redirectIntended(route("filament.patient.pages.dashboard"));
    }

    public function requestFollow(int $doctorId): void
    {
        if (Following::where('patient_id', Auth::id())->exists()) {
            $this->notify('danger', 'Vous avez déjà une demande en cours ou un médecin.');
            return;
        }

        Following::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctorId,
            'status' => FollowingStatus::PENDING,
        ]);

        $this->notify('success', 'Demande envoyée.');
        Notification::make()
            ->title("new follow request")
            ->body(sprintf("patient %s sent a follow request to you, tae an action", Auth::user()->name))
            ->info()
            ->actions([
                Action::make('view')
                    ->url(route('filament.doctor.resources.patients.index'))
                    ->color(Color::Green)
                    ->openUrlInNewTab()
            ])
            ->sendToDatabase(User::find($doctorId));

        $this->redirectIntended(route("filament.patient.pages.dashboard"));
    }

    private function notify(string $type, string $title, ?string $body = null): void
    {
        $notification = Notification::make()
                            ->{$type}()
                            ->title($title);

        if( $body ){
            $notification->body($body);
        }
        $notification->send();
    }
}
