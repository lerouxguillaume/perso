<?php

namespace App\Controller;

use App\Entity\Documents\Episode;
use App\Entity\Documents\Movie;
use App\Entity\Documents\Serie;
use App\Entity\Documents\Video;
use App\Service\VideoStream;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class DocumentController
 * @package App\Controller
 * @Route("/documents")
 */
class DocumentController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $logger;

    private $tokenStorage;

    public function __construct(
        EntityManagerInterface $entityManager, LoggerInterface $logger, Security $security) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->tokenStorage = $security;
    }

    /**
     * @Route(path="/series")
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getSeries(Request $request)
    {
        $user = $this->getUser();
        /** @var Paginator $paginator */
        $paginator = $this->entityManager->getRepository(Serie::class)->findAllSeries($user);

        return $paginator->getIterator();
    }

    /**
     * @Route(path="/movies")
     * @param int $id
     * @return object|null
     */
    public function getMovies()
    {
        return $this->entityManager->getRepository(Movie::class)->findAll();
    }

    /**
     * @Route(path="/serie/{id}")
     * @param int $id
     * @return object|null
     */
    public function getSerie(int $id)
    {
        /** @var Serie $serie */
        $serie = $this->entityManager->getRepository(Serie::class)->find($id);

        $user = $this->getUser();

        if (empty($serie)) {
            throw new NotFoundHttpException();
        }

        if (!$serie->getVisibility() && $user !== $serie->getOwner()){
            throw new AccessDeniedHttpException();
        }
        return $serie;
    }

    /**
     * @Route(path="/video/{id}")
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
     * @TODO refactor all that
     * @Route(path="/video/{dType}/{id}", requirements={"dType"="serie|movie"})
     * @param string $dType
     * @param int $id
     * @return void
     */
    public function downloadVideo(string $dType, int $id)
    {
        if ($dType === 'serie') {
            $contentType = Episode::class;
        } elseif ($dType === 'movie') {
            $contentType = Movie::class;
        }
        /** @var Video $video */
        $content = $this->entityManager->getRepository($contentType)->find($id);

        if (empty($content)) {
            throw new NotFoundHttpException();
        }
        if ($content instanceof Episode) {
            $video = $content->getVideo();
            $content = $content->getSerie();

        } else {
            $video = $content->getVideo();
        }

        if (!$content->getVisibility() && $this->getUser() !== $content->getOwner()){
            throw new AccessDeniedHttpException();
        }
        $response = new VideoStream($video->getFilePath(), $this->logger);
        $response->start();
    }
}