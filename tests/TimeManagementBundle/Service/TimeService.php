<?php

namespace TimeManagementBundle\Tests\Controller\Service;

class TimeService {

    public function getTime() {

        return date();
    }

    public function calcDifference($start, $end) {

        $diff = $end - $start;

        return $diff;
    }

    public function formatDateTime($timestamp) {

        return date("Y.m.d h:i:s", mktime($timestamp));
    }

    public function formatDifference($start, $end) {

        return date("h:i:s", mktime($end - $start));
    }

}
