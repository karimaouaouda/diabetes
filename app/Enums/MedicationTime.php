<?php

namespace App\Enums;

enum MedicationTime : string
{
    case BEFORE_BREAKFAST = 'BEFORE_BREAKFAST';

    case AFTER_BREAKFAST = 'AFTER_BREAKFAST';

    case BEFORE_LUNCH = 'BEFORE_LUNCH';

    case AFTER_LUNCH = 'AFTER_LUNCH';

    case BEFORE_DINNER = 'BEFORE_DINNER';

    case AFTER_DINNER = 'AFTER_DINNER';

    case MIDDLE_BREAKFAST = 'MIDDLE_BREAKFAST';

    case MIDDLE_LUNCH = 'MIDDLE_LUNCH';

    case MIDDLE_DINNER = 'MIDDLE_DINNER';



    public static function values(): array
    {
        $values = [];

        foreach(static::cases() as $case){
            $values[] = $case->value;
        }

        return $values;
    }

    public static function toArray(){
        $values = [];

        foreach(static::cases() as $case){
            $values[$case->value] = $case->name;
        }

        return $values;
    }
}
