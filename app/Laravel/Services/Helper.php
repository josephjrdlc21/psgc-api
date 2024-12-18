<?php

namespace App\Laravel\Services;

use Curl;
use Log;
use Str;

class Helper
{
    public static function create_filename($extension)
    {
        return Str::lower(hash('xxh64', Str::random(10)) . "." . $extension);
    }

    public static function nice_display($string)
    {
        return Str::title(str_replace("_", " ", $string));
    }

    public static function db_amount($number, $sepator = "")
    {
        $amount = str_replace(",", "", $number);
        return number_format($amount, 2, ".", $sepator);
    }

    /**
     * Formats a number to a money format
     *
     * @var string $amount
     *
     * @return int
     */
    public static function money_format($amount)
    {
        $amount = str_replace(",", "", $amount);
        return number_format($amount, 2, '.', ',');
    }

    public static function status_badge($status)
    {
        $result = "default";
        switch (Str::lower($status)) {
            case 'approved':$result = "success";
                break;
            case 'pending':$result = "warning";
                break;
            case 'cancelled':$result = "danger";
                break;
        }
        return $result;
    }

    public static function status_text($status)
    {
        $result = "default";
        switch (Str::lower($status)) {
            case 'approved':$result = "success";
                break;
            case 'pending':$result = "primary";
                break;
            case 'for_correction':$result = "warning";
                break;
            case 'cancelled':$result = "danger";
                break;
        }
        return $result;
    }

    public static function status_format($status)
    {
        return Str::title($status);
    }

    public static function type_format($id_type)
    {
        return ucwords(str_replace('_', ' ', $id_type));
    }

    /**
     * Parse date to the standard sql date format
     *
     * @param date $time
     * @param string $format
     *
     * @return Date
     */
    public static function date_db($time)
    {
        return $time == "0000-00-00 00:00:00" ? "" : date(env('DATE_DB', "Y-m-d"), strtotime($time));
    }

    /**
     * Parse date to the specified format
     *
     * @param date $time
     * @param string $format
     *
     * @return Date
     */
    public static function date_format($time, $format = "M d, Y @ h:i a")
    {
        return $time == "0000-00-00 00:00:00" ? "" : date($format, strtotime($time));
    }

    public static function user_badge_status($group)
    {
        $result = "default";

        switch (Str::lower($group)) {
            case 'active':$result = "primary";
                break;
            case 'inactive':$result = "danger";
                break;
        }
        return $result;
    }

    public static function date_only($time)
    {
        return Self::date_format($time, "F d, Y");
    }

    public static function get_alert_color($status)
    {
        $result = "default";
        switch (Str::lower($status)) {
            case 'failed':
            case 'error':
            case 'danger':
                $result = "danger";
                break;
            case 'success':
                $result = "success";
                break;
            case 'info':
                $result = "info";
                break;
            case 'warning':
                $result = "warning";
                break;
        }
        return $result;
    }

    public static function format_phone($contact_number)
    {
        $contact_number = new PhoneNumber($contact_number);

        if (is_null($contact_number->getCountry())) {
            $contact_number = new PhoneNumber($contact_number, "PH");
        }

        $contact_number = $contact_number->formatE164();
        return $contact_number;
    }
}
