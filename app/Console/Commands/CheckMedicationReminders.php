<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medication;
// app/Console/Commands/CheckMedicationReminders.php
class CheckMedicationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-medication-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   // app/Console/Commands/CheckMedicationReminders.php
public function handle()
{
    $now = now()->format('H:i');

    Medication::where('notifications_enabled', true)
        ->whereDate('start_date', '<=', now())
        ->where(function($query) {
            $query->whereDate('end_date', '>=', now())
                  ->orWhereNull('end_date');
        })
        ->each(function($medication) use ($now) {
            if(in_array($now, $medication->times)) {
                $medication->patient->notify(
                    new MedicationReminderNotification($medication)
                );
            }
        });
}
}
