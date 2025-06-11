<?php

namespace App\Observers;

use App\Jobs\MedicationReminder;
use App\Models\TreatmentMedication;

class TreatmentMedicationObserver
{
    /**
     * Handle the TreatmentMedication "created" event.
     */
    public function created(TreatmentMedication $treatmentMedication): void
    {
        $patient = $treatmentMedication->treatment->patient;

        $start_date = $treatmentMedication->getAttribute('start_date');
        $end_date = $treatmentMedication->getAttribute('end_date');
        $date = $start_date;

        while ($date <= $end_date) {
            foreach($treatmentMedication->getAttribute('times') as $time) {
                $hour = $patient->getHourFor($time['time']);
                $hour -= 1;
                MedicationReminder::dispatch($treatmentMedication, $time['time'], $patient)
                    ->delay($date->setHour($hour));
            }
            $date = $date->addDay();
        }
    }

    /**
     * Handle the TreatmentMedication "updated" event.
     */
    public function updated(TreatmentMedication $treatmentMedication): void
    {
        //
    }

    /**
     * Handle the TreatmentMedication "deleted" event.
     */
    public function deleted(TreatmentMedication $treatmentMedication): void
    {
        //
    }

    /**
     * Handle the TreatmentMedication "restored" event.
     */
    public function restored(TreatmentMedication $treatmentMedication): void
    {
        //
    }

    /**
     * Handle the TreatmentMedication "force deleted" event.
     */
    public function forceDeleted(TreatmentMedication $treatmentMedication): void
    {
        //
    }
}
