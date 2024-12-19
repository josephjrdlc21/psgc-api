<?php

namespace App\Laravel\Traits;

trait ResponseGenerator
{

    public function db_error()
    {
        $response['status'] = false;
        $response['status_code'] = "DB_ERROR";
        $response['msg'] = "Process failed due to internal server error. Please try again.";
        $response_code = 500;

        return ['body' => $response, 'code' => $response_code];
    }

    public function not_found_error()
    {
        $response['status'] = false;
        $response['status_code'] = "NOT_FOUND";
        $response['msg'] = "Record not found.";
        $response_code = 404;

        return ['body' => $response, 'code' => $response_code];
    }

    public function unauthorized_error()
    {
        $response['status'] = false;
        $response['status_code'] = "UNAUTHORIZED";
        $response['msg'] = "Invalid account credentials.";
        $response_code = 401;

        return ['body' => $response, 'code' => $response_code];
    }

    public function date_response($date)
    {
        $response = [
            'date_db' => "",
            'date_only' => "",
            'datetime_ph' => "",
            'date_only_ph' => "",
            'time_passed' => "",
            'timestamp' => "",
            "iso_format" => "",
        ];

        if ($date) {
            $response['date_db'] = $date->format("Y-m-d h:i a");
            $response['date_only'] = $date->format("Y-m-d");
            $response['datetime_ph'] = $date->format("m/d/Y h:i A");
            $response['date_only_ph'] = $date->format("m/d/Y");
            $response['time_passed'] = $date->diffForHumans();
            $response['timestamp'] = $date->toAtomString();
            $response['iso_format'] = $date->toISOString();
            $response['month_year'] = $date->format("M-Y");

        }
        return $response;
    }

    public function api_response($data)
    {
        $meta = [
            'meta' => [
                'copyright' => "Copyright " . now()->format("Y") . " PSGC API",
                'authors' => [
                    "PSGC",
                ],
                'jsonapi' => [
                    'version' => env("APP_VERSION"),
                    'build' => env("APP_BUILD_NUMBER"),
                ],
            ],
        ];

        return $meta + $data;
    }

    public function image_response($directory = '', $path = '', $filename = '')
    {
        $response = [
            'filename' => "",
            'path' => "",
            'directory' => "",
            'full_path' => "",
            'thumb_path' => "",
        ];

        if ($filename) {
            $response['filename'] = $filename;
            $response['path'] = $path;
            $response['directory'] = $directory;
            $response['full_path'] = "{$directory}/resized/{$filename}";
            $response['thumb_path'] = "{$directory}/thumbnails/{$filename}";
        }

        return $response;
    }
}
