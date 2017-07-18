<?php
// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use AppBundle\Service\LuckyService;
use AppBundle\Model\UserViewModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $service = new LuckyService();
        $model = new UserViewModel();
        
        $model->number = $service->generateLuckyNumber();
        $model->color = $service->generateLuckyColor();
  
         return $this->render('lucky/number.html.twig', array(
                 'model' => $model,
            ));
       
    }
}
