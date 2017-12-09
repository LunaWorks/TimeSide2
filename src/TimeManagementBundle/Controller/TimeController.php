<?php

namespace TimeManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TimeManagementBundle\Service\TimeService;
use \Datetime;

class TimeController extends Controller
{
    private $time;
    private $time2;

    /**
     * @Route("/time/start")
     */
    public function start() {
        $result = 0;
        $date = new DateTime();
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time = $date->getTimestamp(), 
            'time2' =>$this->time2 = $date->getTimestamp(),
            'result' => $result    
        ));
    }
    /**
     * @Route("/time/stop")
     */
    public function stop() {
        $result = 0;
        $date2 = new DateTime();
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time = $date->getTimestamp(), 
            'time2' =>$this->time2 = $date->getTimestamp(),
            'result' => $result    
        ));
    }
    /**
     * @Route("/time/split")
     */
    public function getResult() {
        $service = new TimeService();
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time, 
            'time2' =>$this->time2,
            'result' => $result = $service->calcDifference($this->time,$this->time2)
        ));
    }
}

     

