<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\{Storage,Config};

if (! function_exists('get_times')) {
    function get_times( $default = '19:00', $interval = '+30 minutes' ) {

        $output = '';

        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );
        $output = "<option value=''>Select</option>";
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            //$sel = ( $time == $default ) ? ' selected' : '';
            $sel = ( $time == $default ) ? ' ' : '';
            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }

        return $output;
    }
}

if (! function_exists('fileUpload')) {
    function fileUpload( $fileName, $directory, $isPrivate = null ) {
        try {
            // Handle File Upload
            if (request()->hasFile($fileName)) {
                // Get filename with extension
                $filenameWithExt = request()->file($fileName)->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = request()->file($fileName)->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $filePath = "uploads/" . $directory . '/' . $fileNameToStore;
                $exists = Storage::exists($filePath);
                if (!$exists) {
                    if ($isPrivate) {
                        Storage::put($filePath, file_get_contents(request()->file($fileName)));
                    } else {
                        Storage::put($filePath, file_get_contents(request()->file($fileName)), 'public');
                    }
                }
                $file_url = $filePath;

                return $file_url;
            } else {
                return 'File doesn\'t exist';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

if (! function_exists('fileUrl')) {
    function fileUrl($path = null, $isPrivate = null)
    {
        if ($isPrivate) {
            // This code for generate new signed url of your file
            $value = $path;
            $disk = Storage::disk('s3');

            if ($disk->exists($value))
            {
                $s3 = Storage::disk('s3');
                $client = $s3->getDriver()->getAdapter()->getClient();
                $expiry = "+10 minutes";

                $command = $client->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                    'Key'    => $value
                ]);

                $request = $client->createPresignedRequest($command, $expiry);

                return (string) $request->getUri();
            }
        } else {
            return 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $path;
        }
    }
}

/**
 * *** To Be Used Later ****
 *
 * Loops through all dates and checks to see if they are standard holidays or weekends and therefor should not be counted as vacation or sick days
 *
 * @param CalendarTimeoff $calendarTimeoff
 *
 * @return int
 */
/*function getWorkableDays (CalendarTimeoff $calendarTimeoff) {

    $easter = Carbon::createMidnightDate(date('Y'), 3, 21)->addDays(easter_days(date('Y')));
    $holidays = [
        '01/01', // New Years
        Carbon::parse('third monday of February ' . date('Y'))->format('d/m'), // BC Family Day
        $easter->subDay(3)->format('d/m'), // good friday
        // $easter->format('d/m'), // easter
        Carbon::parse('May 24 ' . date('Y'))->startOfWeek()->format('d/m'), // Victoria Day
        '01/07', // Canada Day
        Carbon::parse('first Monday of August ' . date('Y'))->format('d/m'),// BC Day
        Carbon::parse('first Monday of September ' . date('Y'))->format('d/m'),// Labour Day
        Carbon::parse('second Monday of October ' . date('Y'))->format('d/m'), // Thanksgiving
        '11/11',// Remembrance Day
        '24/12',
        '25/12', // Christmas
        '26/12',
    ];

    $weekdays = $calendarTimeoff->start->diffInDaysFiltered(function (Carbon $date) use ($holidays) {
        // including Y != current year allows skipping of dates that overlap the beginning or end of the year
        if (in_array($date->format('d/m'), $holidays) || $date->format('Y') != date('Y')) {
            return false;
        }

        return !$date->isWeekend();
    }, $calendarTimeoff->end);

    $diff = $calendarTimeoff->start->diffInHours($calendarTimeoff->end);

    // if no end or start = end
    if (is_null($calendarTimeoff->end) || $calendarTimeoff->start == $calendarTimeoff->end) {
        return 1;
    }

    // if it's an all day event the hours difference is > 4
    if ($calendarTimeoff->is_all_day) {
        return $weekdays + 1; // add 1 day because we don't want just between, we want to include the day back
    }
    elseif ($diff >= 5) {
        if ($diff > 24) {
            $mod = $diff % 24;

            if ($mod == 0) {
                return $weekdays;
            }
            if ($mod < 5) {
                return $weekdays + .5;
            }

            return $weekdays + 1;
        }
        else {
            return $weekdays;
        }
    }

    return 0.5;

}*/
