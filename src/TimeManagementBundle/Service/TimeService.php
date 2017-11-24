<?php

namespace TimeManagementBundle\Service;

class TimeService {

    public function getTime() {

        return date();
    }

    public function calcDifference($start, $end) {

        return $end - $start;
    }

    public function formatDateTime($timestamp) {

        return date("h:m:s", mktime($timestamp));
    }

    public function formatDifference($start, $end) {

        return date("h:i:s", mktime(calcDifference($start, $end)));
    }

}
