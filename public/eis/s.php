<pre>
<?php

$results = [];

function find_dates_between($start_date, $end_date)
{

    $start_date = DateTime::createFromFormat('Y-m-d', $start_date);
    $end_date = DateTime::createFromFormat('Y-m-d', $end_date);

    $interval = new \DateInterval('P1D');
    $end_date->add($interval);
    $daterange = new \DatePeriod($start_date, $interval, $end_date);

    foreach ($daterange as $date) {

        // $date1 = strtotime($date);
        $date1 = $date->format('l');
        print_r($date1);
        $date1 = strtolower($date1);
        if ($date1 != 'saturday' && $date1 != 'sunday') {
            echo $date->format('Ymd');
            $results[$date->format('Ymd')] = $date->format('Ymd');
        }
    }
    print_r($results);
}

find_dates_between('2024-08-01', '2024-08-11');

print_r($results);

// session_start();
// echo "<pre>";
// print_r($_SESSION);
