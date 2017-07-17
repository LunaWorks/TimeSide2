<?php
// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use AppBundle\Service\LuckyService;
use AppBundle\Model\UserViewModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
class LuckyController
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $service = new LuckyService();
        $number = $service->generateLuckyNumber();
        $color = $service->generateLuckyColor();

        return new Response(
            '<html><body>Lucky number: '.$model->number = $service->generateLuckyNumber().'</br>Random color: '.$model->color = $service->generateLuckyNumber().'</body></html>'
        );
    }
}
