<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Notification::make()
            ->title(sprintf("welcome %s", $user->name))
            ->icon('heroicon-o-hand-raised')
            ->body('welcome to %s platform', config('app.name'))
            ->send()
            ->sendToDatabase($user);

        if( $user->isDoctor() ){
            $this->doctorCreatedEvent($user);
        }else{
            $this->patientCreatedEvent($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    private function doctorCreatedEvent(User $user)
    {

    }

    private function patientCreatedEvent(User $user)
    {
        $user->patientProfile()->create([
            'blood_type' => 'B+',
            'height' => 160,
            'weight' => 60,
            'meals' => ['breakfast' => '08:00', 'lunch'=> '12:00', 'dinner' => '20:00'],
        ]);

        $user->insulineSettings()
            ->create([
                'doctor_id' => null,
                'target_glucose' => 120,
                'correction_factor' => 50,
                'carb_ratio' => 10,
            ]);

        Notification::make()
            ->title("please review your information")
            ->icon('heroicon-o-hand-raised')
            ->body("we fill your information by default, please recheck them")
            ->actions([
                Action::make('view')
                    ->url(to_route('filament.patient.auth.profile'))
                    ->openUrlInNewTab()
            ])
            ->send()
            ->sendToDatabase($user);
    }
}
