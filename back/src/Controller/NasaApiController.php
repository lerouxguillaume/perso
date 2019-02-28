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
     * @Get(
     *      path="/day/{date}",
     *      requirements={
     *          "date" = "^\s*(3[01]|[12][0-9]|0?[1-9])\-(1[012]|0?[1-9])\-((?:19|20)\d{2})\s*$"
     *      },
     *      defaults={"date" = null}
     *      )
     * @View
     * @param null $date
     * @return ImageOfTheDay
     * @throws \Exception
     */
    public function imageOfTheDay($date = null)
    {
        $dateTime = new \DateTime($date);
        /** @var ImageOfTheDay $imageOfTheDay */
        $imageOfTheDay = $this->fetchApiNasa->getImageOfTheDay($dateTime);
        return $imageOfTheDay;
    }
    /**
     *
     * @Get(
     *      path="/day/last/{number}",
     *      requirements={
     *          "number" = "\d+"
     *      }
     *      )
     * @View
     * @param null $date
     * @return array
     * @throws \Exception
     */
    public function lastImagesOfTheDay(int $number)
    {
        $dateTime = new \DateTime('now');
        $res = [];
        while ($number > 0) {
            $number--;
            $res[] = $this->fetchApiNasa->getImageOfTheDay($dateTime);
            $dateTime->modify('-1 day');
        }

        return $res;
    }
}