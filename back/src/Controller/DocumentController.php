<?php

namespace App\Controller;

use App\Entity\Documents\Video;
use App\Security\AuthenticateUrlProvider;
use App\Security\Voter\VideoVoter;
use App\Service\VideoStream;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DocumentController
 * @package App\Controller
 * @Route("/documents")
 */
class DocumentController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var AuthenticateUrlProvider */
    private $authenticateUrlProvider;

    /**
     * DocumentController constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @param AuthenticateUrlProvider $authenticateUrlProvider
     */
    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        AuthenticateUrlProvider $authenticateUrlProvider
    ){
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->authenticateUrlProvider = $authenticateUrlProvider;
    }

    /**
     * @Route(name="videoDownload", path="/video/{id}")
     * @param int $id
     * @return void
     */
    public function downloadVideo(Request $request, int $id)
    {
        $this->authenticateUrlProvider->authenticateUser($request);

        /** @var Video $video */
        $video = $this->entityManager->getRepository(Video::class)->find($id);
        if (empty($video)) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted(VideoVoter::VIEW, $video);

        $response = new VideoStream($video->getFilePath(), $this->logger);

        $response->start();
    }
}