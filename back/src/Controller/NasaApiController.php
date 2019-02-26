<?php

namespace App\Controller;

use App\Entity\ImageOfTheDay;
use App\Service\FetchApiNasa;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;

class NasaApiController extends AbstractFOSRestController
{
    private $fetchApiNasa;

    public function __construct(FetchApiNasa $fetchApiNasa)
    {
        $this->fetchApiNasa = $fetchApiNasa;
    }

    /**
     * @Get(path="/day")
     * @View
     * @throws \Exception
     */
    public function number()
    {
        /** @var ImageOfTheDay $imageOfTheDay */
        $imageOfTheDay = $this->fetchApiNasa->getImageOfTheDay();
//        dump($imageOfTheDay);die();
        return $imageOfTheDay;
    }
}