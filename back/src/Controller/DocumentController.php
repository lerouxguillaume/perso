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
use RuntimeException;
use SplFileObject;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
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

//    /**
//     * @Get(path="/download/{id}")
//     * @View
//     * @param int $id
//     * @return object|null
//     */
//    public function downloadVideo(int $id)
//    {
//        /** @var Video $video */
//        $video = $this->entityManager->getRepository(Video::class)->find($id);
//
//        if (empty($video)) {
//            throw new NotFoundHttpException();
//        }
//
//        return new BinaryFileResponse(stripslashes($video->getFilePath()));
//    }

    /**
     * FIXME : Look at that
     * https://stackoverflow.com/questions/14559371/symfony2-video-streaming
     * @Get(path="/download/{id}")
     * @View
     * @param Request $request
     * @param int $id
     * @return object|null
     */
    public function streamAction(Request $request, int $id) {
        // Create the StreamedResponse object
        $response = new StreamedResponse();

        /** @var Video $video */
        $video = $this->entityManager->getRepository(Video::class)->find($id);

        if (empty($video)) {
            throw new NotFoundHttpException();
        }
        try {
            $file = new SplFileObject($video->getFilePath());
        }
        catch (RuntimeException $runtimeException) {
            // The file cannot be opened (permissions?)
            // throw new AnyCustomFileErrorException() maybe?
        }

        // Check file existence
        if (!($file->isFile())) {
            // The file does not exists, or is not a file.
            throw $this->createNotFoundException('This file does not exists, or is not a valid file.');
        }

        // Retrieve file informations
        $fileExt  = $file->getExtension();
        $fileSize = $file->getSize();

        // Guess MIME Type from file extension
        $mime = 'video';

        $mime .= '/' . $fileExt;

        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Content-Type', $mime);

        // Prepare File Range to read [default to the whole file content]
        $rangeMin = 0;
        $rangeMax = $fileSize - 1;
        $rangeStart = $rangeMin;
        $rangeEnd = $rangeMax;

        $httpRange = $request->server->get('HTTP_RANGE');

        // If a Range is provided, check its validity
        if ($httpRange) {
            $isRangeSatisfiable = true;

            if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $httpRange, $matches)) {
                $rangeStart  = intval($matches[1]);

                if (!empty($matches[2])) {
                    $rangeEnd  = intval($matches[2]);
                }
            } else {
                // Requested HTTP-Range seems invalid.
                $isRangeSatisfiable = false;
            }

            if ($rangeStart <= $rangeEnd) {
                $length = $rangeEnd - $rangeStart + 1;
            } else {
                // Requested HTTP-Range seems invalid.
                $isRangeSatisfiable = false;
            }

            if ($file->fseek($rangeStart) !== 0) {
                // Could not seek the file to the requested range: it might be out-of-bound, or the file is corrupted?
                // Assume the range is not satisfiable.
                $isRangeSatisfiable = false;

                // NB : You might also wish to throw an Exception here...
                // Depending the server behaviour you want to set-up.
                // throw new AnyCustomFileErrorException();
            }

            if ($isRangeSatisfiable) {
                // Now the file is ready to be read...
                // Set additional headers and status code.
                // Symfony < 2.4
                // $response->setStatusCode(206);
                // Or using Symfony >= 2.4 constants
                $response->setStatusCode(StreamedResponse::HTTP_PARTIAL_CONTENT);

                $response->headers->set('Content-Range', sprintf('bytes %d/%d', $rangeStart - $rangeEnd, $fileSize));
                $response->headers->set('Content-Length', $length);
                $response->headers->set('Connection', 'Close');
            } else {
                $response = new Response();

                // Symfony < 2.4
                // $response->setStatusCode(416);
                // Or using Symfony >= 2.4 constants
                $response->setStatusCode(StreamedResponse::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE);
                $response->headers->set('Content-Range', sprintf('bytes */%d', $fileSize));

                return $response;
            }
        } else {
            // No range has been provided: the whole file content can be sent
            $response->headers->set('Content-Length', $fileSize);
        }

        // At this step, the request headers are ready to be sent.
        $response->prepare($request);
        $response->sendHeaders();

        // Prepare the StreamCallback
        $response->setCallback(function () use ($file, $rangeEnd) {
            $buffer = 1024 * 8;

            while (!($file->eof()) && (($offset = $file->ftell()) < $rangeEnd)) {
                set_time_limit(0);

                if ($offset + $buffer > $rangeEnd) {
                    $buffer = $rangeEnd + 1 - $offset;
                }

                echo $file->fread($buffer);
            }

            // Close the file handler
            $file = null;
        });

        // Then everything should be ready, we can send the Response content.
        $response->sendContent();

        // DO NOT RETURN $response !
        // It has already been sent, both headers and body.
    }
}