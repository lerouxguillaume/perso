<?php

namespace App\Controller;

use App\Entity\ImageOfTheDay;
use App\Service\FetchApiAlphaVantage;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;

/**
 * Class NasaApiController
 * @package App\Controller
 * @Route("/trading")
 */
class BourseApiController extends AbstractFOSRestController
{
    /** @var FetchApiAlphaVantage */
    private $alphaAvantageApi;

    public function __construct(FetchApiAlphaVantage $fetchApiAlphaVantage)
    {
        $this->alphaAvantageApi = $fetchApiAlphaVantage;
    }

    /**
     * @Get(path="/entreprises")
     * @View
     * @return array
     */
    public function getEntreprises()
    {
        $response = $this->alphaAvantageApi->getEntreprises();
        return $response;
    }

    /**
     * @Get(path="/daily/{symbol}")
     * @View
     * @param null $date
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function imageOfTheDay($symbol)
    {
        $response = $this->alphaAvantageApi->getDailyCotes($symbol);
        return $response;
    }
}