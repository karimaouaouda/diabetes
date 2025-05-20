<?php

namespace App\Enums;

enum informationtype : string
{
    case BEFORE_BREAKFAST = 'Glycémie actuelle';




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
