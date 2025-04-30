<?php

namespace App\Enums;

enum InformationOrder : string
{
    case BEFORE_BREAKFAST = 'BEFORE_BREAKFAST';

    case AFTER_BREAKFAST = 'AFTER_BREAKFAST';

    case BEFORE_LUANH = 'BEFORE_LUANH';

    case AFTER_LUNCH = 'AFTER_LUNCH';

    case BEFORE_DINNER = 'BEFORE_DINNER';

    case AFTER_DINNER = 'AFTER_DINNER';



    public static function values(){
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
