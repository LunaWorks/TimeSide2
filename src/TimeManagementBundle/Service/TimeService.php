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

        return date("H:i:s", $timestamp);
    }

    public function formatDifference($start, $end) {

        return date("H:i:s", $this->calcDifference($start, $end));
    }

}
