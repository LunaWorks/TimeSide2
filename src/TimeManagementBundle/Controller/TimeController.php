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
    private $service;
    
    public function __construct(){
          $this->service = new TimeService();
    }
    
      /**
     * @Route("/time")
     */
    public function index() {
        $date = new DateTime();
        $this->time = null;
        $this->time2 = null;
        $result = 0;
        
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time, 
            'time2' =>$this->time2,
            'result' => $this->service->formatDateTime($result)    
        ));
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
            'time' =>$this->time,
            'time2' =>$this->time2,
            'result' => $this->service->formatDateTime($result)    
        ));
    }
    /**
     * @Route("/time/stop/{start}")
     */
    public function stop($start) {
        $this->time = $start;
        $date2 = new DateTime();
        $this->time2 = $date2->getTimestamp();
        $result =  $this->service->calcDifference($this->time, $this->time2);
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time, 
            'time2' =>$this->time2,
            'result' => $this->service->formatDateTime($result)    
        ));
    }
    /**
     * @Route("/time/split/{start}")
     */
    public function getResult($start) {
        $this->time = $start;
        $date2 = new DateTime();
        $this->time2 = $date2->getTimestamp();
        $result =  $this->service->calcDifference($this->time, $this->time2);
        
        return $this->render('time/time.html.twig', array(
            'time' =>$this->time, 
            'time2' =>$this->time2,
            'result' => $this->service->formatDateTime($result)    
        ));
    }
}

     

