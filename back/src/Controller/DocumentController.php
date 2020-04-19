<?php

namespace App\Controller;

use App\Entity\Documents\Video;
use App\Service\VideoStream;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @TODO Security
     * @Route(name="videoDownload", path="/video/{id}")
     * @param int $id
     * @return void
     */
    public function downloadVideo(Request $request, int $id)
    {
        if ($accessToken = $request->get('access_token')) {
            dump($accessToken);
            die();
        }

        /** @var Video $video */
        $video = $this->entityManager->getRepository(Video::class)->find($id);
        if (empty($video)) {
            throw new NotFoundHttpException();
        }

        $response = new VideoStream($video->getFilePath(), $this->logger);
        $response->start();
    }
}