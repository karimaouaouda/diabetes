<?php

namespace App\Filament\Patient\Pages;

use App\Enums\FollowingStatus;
use App\Models\Following;
use App\Models\User;
use App\Enums\UserRoles;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class DoctorSearch extends Page
{
    use WithPagination;

    protected static ?string $navigationLabel = 'Trouver un médecin';
    protected static ?string $title = 'Recherche de médecins';
    protected static ?string $slug = 'doctor-search';
    protected static string $view = 'filament.patient.pages.doctor-search';

    public string $search = '';

    public function getDoctorsProperty()
    {
        return User::where('role', UserRoles::DOCTOR)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })->paginate(8);
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
    }
}
