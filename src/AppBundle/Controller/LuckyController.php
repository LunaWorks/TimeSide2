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
        $model = new UserViewModel();
        $model->number = $service->generateLuckyNumber();
        $model->color = $service->generateLuckyNumber();
        return new Response(
            '<html><body>Lucky number: '.$model->number.'</br>Random color: '.$model->color.'</body></html>'
        );
    }
}
