<?php

namespace App\Controller;

use App\Service\FetchApiAlphaVantage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NasaApiController
 * @package App\Controller
 * @Route("/trading")
 */
class BourseApiController extends AbstractController
{
    /** @var FetchApiAlphaVantage */
    private $alphaAvantageApi;

    public function __construct(FetchApiAlphaVantage $fetchApiAlphaVantage)
    {
        $this->alphaAvantageApi = $fetchApiAlphaVantage;
    }

    /**
     * @Route(path="/entreprises")
     * @return array
     */
    public function getEntreprises()
    {
        $response = $this->alphaAvantageApi->getEntreprises();
        return $response;
    }
}