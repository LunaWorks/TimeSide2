<?php

namespace TimeManagementBundle\Tests\Controller\Service;

class TimeService {

    public function getTime() {

        return date();
    }

    public function calcDifference($start, $end) {

        return $end - $start;
    }

    public function formatDateTime($timestamp) {

        return date("Y.m.d h:i:s", mktime($timestamp));
    }

    public function formatDifference($start, $end) {

        return date("h:i:s", mktime(calcDifference($start, $end)));
    }

}
