<?php

class GPS {

    public static function calcDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        /**
        * Calculates the great-circle distance between two points, with
        * the Haversine formula.
        * @param float $latitudeFrom Latitude of start point in [deg decimal]
        * @param float $longitudeFrom Longitude of start point in [deg decimal]
        * @param float $latitudeTo Latitude of target point in [deg decimal]
        * @param float $longitudeTo Longitude of target point in [deg decimal]
        * @param float $earthRadius Mean earth radius in [m]
        * @return float Distance between points in [m] (same as earthRadius)
        */
        $earthRadius = 6371000;

        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return $distance;
    }
}


// DB::table('services')->select('gps_latitude', 'gps_longitude')
//     ->where(DB::raw('(6371000 * (2 * asin(sqrt (pow(sin((gps_latitude - :lat)/2),2)
//                     + cos(:lat)*cos(gps_latitude)*pow(sin((gps_longitude - :lon)/2),2)))))
//                     < :range'), ['lat' => $,
//                                  'lon' => $,
//                                  'range' => $range]);
