<?php

namespace App\Controller;

use App\Service\FetchApiNasa;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NasaApiController extends AbstractFOSRestController
{
    private $fetchApiNasa;

    public function __construct(FetchApiNasa $fetchApiNasa)
    {
        $this->fetchApiNasa = $fetchApiNasa;
    }

    /**
     * @Route("/lucky/number")
     * @return Response
     * @throws \Exception
     */
    public function number()
    {
        $number = random_int(0, 100);
        $this->fetchApiNasa->getImageOfTheDay();
        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}