<?php

namespace App\Jobs;

use App\Models\TreatmentMedication;
use App\Models\User;
use App\Notifications\MedicationReminderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class MedicationReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public TreatmentMedication $treatment_medication, public string $time, public User $patient)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Filament\Notifications\Notification::make()
            ->title('Medication Reminder')
            ->body(sprintf("it's time to get your medication : %s, %s ", $this->treatment_medication->medication->name, $this->time))
            ->sendToDatabase($this->patient);
    }
}
