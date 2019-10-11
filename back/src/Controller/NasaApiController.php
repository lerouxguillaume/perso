<?php

namespace App\Controller;

use App\Entity\ImageOfTheDay;
use App\Service\FetchApiNasa;
use DateInterval;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class NasaApiController.
 *
 * @Route("/nasa")
 */
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
     *
     * @param null $date
     *
     * @return ImageOfTheDay
     *
     * @throws Exception
     */
    public function imageOfTheDay($date = null)
    {
        $dateTime = new DateTime($date);
        /** @var ImageOfTheDay $imageOfTheDay */
        $imageOfTheDay = $this->fetchApiNasa->getImageOfTheDay($dateTime);

        return $imageOfTheDay;
    }

    /**
     * @Get(
     *      path="/search/{from}/{limit}",
     *      requirements={
     *          "from" = "^\s*(3[01]|[12][0-9]|0?[1-9])\-(1[012]|0?[1-9])\-((?:19|20)\d{2})\s*$",
     *          "limit" = "^\d+"
     *      },
     *      defaults={"from" = null}
     *      )
     * @View
     *
     * @param Request $request
     * @param string  $from
     * @param int     $limit
     *
     * @return array
     *
     * @throws Exception
     */
    public function searchImageNasa(Request $request, $from, $limit)
    {
        try {
            $dateTime = new DateTime($from);
        } catch (Exception $e) {
            throw new BadRequestHttpException('Le format de la date '.$from.' n\est pas reconnu');
        }

        $imageOfTheDays = [];

        while ($limit > 0) {
            /* @var ImageOfTheDay $imageOfTheDay */
            try {
                $imageOfTheDays[] = $this->fetchApiNasa->getImageOfTheDay($dateTime);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            $dateTime->sub(new DateInterval('P1D'));
            --$limit;
        }

        return $imageOfTheDays;
    }
}
