<?php

namespace App\Controller;

use App\Entity\ImageOfTheDay;
use App\Service\FetchApiNasa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NasaApiController
 * @package App\Controller
 * @Route("/nasa")
 */
class NasaApiController extends AbstractController
{
    private $fetchApiNasa;

    public function __construct(FetchApiNasa $fetchApiNasa)
    {
        $this->fetchApiNasa = $fetchApiNasa;
    }

    /**
     * @Route(
     *      path="/day/{date}",
     *      requirements={
     *          "date" = "^\s*(3[01]|[12][0-9]|0?[1-9])\-(1[012]|0?[1-9])\-((?:19|20)\d{2})\s*$"
     *      },
     *      defaults={"date" = null}
     *      )
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
     * @Route(
     *      path="/search/{from}/{limit}",
     *      requirements={
     *          "from" = "^\s*(3[01]|[12][0-9]|0?[1-9])\-(1[012]|0?[1-9])\-((?:19|20)\d{2})\s*$",
     *          "limit" = "^\d+"
     *      },
     *      defaults={"from" = null}
     *      )
     * @param Request $request
     * @param string $from
     * @param int $limit
     * @return array
     * @throws \Exception
     */
    public function searchImageNasa(Request $request, $from, $limit)
    {
        try {
            $dateTime = new \DateTime($from);
        } catch (\Exception $e) {
            throw new BadRequestHttpException('Le format de la date '.$from.' n\est pas reconnu');
        }

        $imageOfTheDays = [];

        while ($limit > 0) {
            /** @var ImageOfTheDay $imageOfTheDay */
            try {
                $imageOfTheDays[] = $this->fetchApiNasa->getImageOfTheDay($dateTime);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
            $dateTime->sub(new \DateInterval('P1D'));
            $limit--;
        }
        return $imageOfTheDays;
    }
}