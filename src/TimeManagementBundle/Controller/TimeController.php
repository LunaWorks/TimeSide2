<?php

namespace TimeManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TimeManagementBundle\Service\TimeService;
use \Datetime;

class TimeController extends Controller
{
     /**
     * $Path("/time/time.html.twig'")
     */
    private $time;
    private $time2;

    public function start() {
        $date = new DateTime();
        return $this->render('time/time.html.twig', array('time' =>  $this->time = $date->getTimestamp()));
    }

    public function stop() {
        $date2 = new DateTime();
        return $this->render('time/time.html.twig', array('time2' =>  $this->time2 = $date2->getTimestamp()));
    }

    public function getResult() {
        $service = new TimeService();
        $result =  $service->formatDifference($time, $time2);
        return $this->render('time/time.html.twig', array('result' => $result));
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
     

