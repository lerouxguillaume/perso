<?php

namespace App\Controller;

use App\Entity\Documents\Movie;
use App\Entity\Documents\Serie;
use App\Entity\Documents\Video;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NasaApiController
 * @package App\Controller
 * @Route("/documents")
 */
class DocumentController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Get(path="/series")
     * @View
     * @return array
     */
    public function getSeries()
    {
        return $this->entityManager->getRepository(Serie::class)->findAll();
    }

    /**
     * @Get(path="/movies")
     * @View
     * @param int $id
     * @return object|null
     */
    public function getMovies()
    {
        return $this->entityManager->getRepository(Movie::class)->findAll();
    }

    /**
     * @Get(path="/serie/{id}")
     * @View
     * @param int $id
     * @return object|null
     */
    public function getSerie(int $id)
    {
        /** @var Serie $serie */
        $serie = $this->entityManager->getRepository(Serie::class)->find($id);

        if (empty($serie)) {
            throw new NotFoundHttpException();
        }
        return $serie;
    }

    /**
     * @Get(path="/video/{id}")
     * @View
     * @param int $id
     * @return object|null
     */
    public function getVideo(int $id)
    {
        /** @var Video $video */
        $video = $this->entityManager->getRepository(Video::class)->find($id);

        if (empty($video)) {
            throw new NotFoundHttpException();
        }
        return $video;
    }

    /**
     * @Get(path="/download/{id}")
     * @View
     * @param int $id
     * @return object|null
     */
    public function downloadVideo(int $id)
    {
        /** @var Video $video */
        $video = $this->entityManager->getRepository(Video::class)->find($id);

        if (empty($video)) {
            throw new NotFoundHttpException();
        }

        return new BinaryFileResponse(stripslashes($video->getFilePath()));
    }
}