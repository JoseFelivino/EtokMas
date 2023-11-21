<?php


namespace App\Helpers\General;
use Carbon\Carbon;

class DateHelper
{
    public const SYSTEM_FORMAT = 'Y-m-d H:i:s';
    public const USER_FORMAT = 'd-m-Y H:i:s';
    public const USER_DATE_FORMAT = 'd-m-Y';
    public const FRONT_END_FORMAT = 'Y-m-d';
    
    public static function changeFormatToFormat($currentFormat, $toFormat, $date) {
        return Carbon::createFromFormat($currentFormat, $date)->format($toFormat);
    }

    public static function createCarbonFromFormat($format, $date) {
        return Carbon::createFromFormat($format, $date);
    }

    public static function getTodayDateCarbonWithSystemFormat() {
        return Carbon::now()->format(self::SYSTEM_FORMAT);
    }

    public static function getTodayDateCarbonWithUserFormat() {
        return Carbon::now()->format(self::USER_FORMAT);
    }

    public static function getTodayDateCarbonWithUserDateFormat() {
        return Carbon::now()->format(self::USER_DATE_FORMAT);
    }
}