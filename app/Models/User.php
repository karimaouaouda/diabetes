<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRoles;
use App\Observers\UserObserver;
use App\Traits\CanHaveConversation;
use App\Traits\HasAvatar;
use App\Traits\HasDoctorRole;
use App\Traits\HasPatientRole;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        Notifiable,
        HasDoctorRole,
        HasAvatar,
        HasPatientRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'date_of_birth',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRoles::class
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }





    /* public function canAccessPanel(Panel $panel): bool
    {
        return $;
    } */




    public function followings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followings', 'patient_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'followings', 'doctor_id');
    }

    public function followingRequest()
    {
        return $this->hasOne(Following::class, 'patient_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(Following::class, 'doctor_id');
    }


    /**
     * @throws \Exception
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->getAttribute('role')->value == $panel->getId();
    }
    public function insulinSettings()
    {
        return $this->hasOne(InsulinSettings::class);
    }

    /**
     * Obtenir les calculs d'insuline de l'utilisateur.
     */
    public function insulinCalculations()
    {
        return $this->hasMany(InsulinCalculation::class);
    }
    public function insulinEntries()
{
    return $this->hasMany(InsulinEntry::class);
}

public function settings()
{
    return $this->hasOne(UserSetting::class);
}
}
