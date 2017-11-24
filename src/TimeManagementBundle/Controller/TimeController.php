<?php

namespace TimeManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TimeManagementBundle\Service\TimeService;
use \Datetime;

class TimeController extends Controller
{
    private $service;
    private $time;
    private $time2;

    /**
     * TimeController constructor.
     */
    public function __construct()
    {
        $this->service = new TimeService();
    }


    /**
     * @Route("/time/start")
     */
    public function start() {
        $date = new DateTime();
        $this->time = $date->getTimestamp();
        $this->time2 = null;
        $result = 0;

        return $this->render('time/time.html.twig', array(
            'time' =>  $this->time,
            'time2' =>  $this->time2,
            'result' => $result
        ));
    }

    /**
     * @Route("/time/stop/{start}")
     */
    public function stop($start) {
        $this->time = $start;
        $date2 = new DateTime();
        $this->time2 = $date2->getTimestamp();
        $result =  $this->service->formatDifference($this->time, $this->time2);

        return $this->render('time/time.html.twig', array(
            'time' =>  $this->time,
            'time2' =>  $this->time2,
            'result' => $result
        ));
    }

    /**
     * @Route("/time/split/{start}")
     */
    public function getResult($start) {
        $this->time = $start;
        $date2 = new DateTime();
        $this->time2 = $date2->getTimestamp();

        $result =  $this->service->formatDifference($this->time, $this->time2);

        return $this->render('time/time.html.twig', array(
            'time' =>  $this->time,
            'time2' =>  $this->time2,
            'result' => $result
        ));
    }
}
    

       
    /*
    public function indexAction()
    {
         $service = new TimeService();
         
         $diff = $service->formatDateTime(SELF::getResult());
         
        return $this->render('time/time.html.twig', array(

                    'time' => SELF::start(),
                    'time2' => SELF::stop(),
                    'diff' => $diff,
        ));
    }
      */
     

