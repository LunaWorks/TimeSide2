<?php

namespace TimeManagementBundle\Tests\Controller\Service;

class TimeService {

    public function getTime() {

        return date();
    }

    public function calcDifference($day1, $month1, $year1, $day2, $month2, $year2) {

        $today = date($day - $month1 - $year1);
        $givenDate = date($year2 - $month2 - $day2);
        $dateDiff = $givenDate - $today;

        return $dateDiff;
    }

    public function formatDateTime() {

        $date = now();
        return date_format($date, 'Y.m.d H:i:s');
    }

    public function formatDifference() {

        return "";
    }

}
