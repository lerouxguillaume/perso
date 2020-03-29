<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Serie;
use App\Entity\Video;
use App\Service\FileUploader;
use App\Service\ThreadTest;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    /**
     * @var FileUploader
     */
    private $fileUploader;

    public function __construct(
        EntityManagerInterface $entityManager,
    FileUploader $fileUploader
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }


    /**
     * @SWG\Tag(name="Document API")
     * @SWG\Response(
     *     response=200,
     *     description="Returns 200 if OK",
     * )
     * @SWG\Parameter(
     *     name="document",
     *     in="body",
     *     type="file",
     *     description="File to upload",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Items(ref=@Model(type=Document::class, groups={"full"}))
     *     )
     * )
     * @Post(path="/upload")
     * @View
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
//    public function postDocument(Request $request)
//    {
//        $tmpFile = $request->files->get('uploadedFile');
//        $document = $this->fileUploader->uploadFile($tmpFile, $this->getUser());
//
//        $this->entityManager->persist($document);
//        $this->entityManager->flush();
//
//        return $this->handleView(
//            $this->view(
//                [
//                    'status' => 'ok',
//                ],
//                Response::HTTP_CREATED
//            )
//        );
//    }

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
     * @Get(path="/videos")
     * @View
     * @return array
     */
    public function getVideos()
    {
        return $this->entityManager->getRepository(Video::class)->findAll();
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


    /**
     *  Flattens a given filebag to extract all files.
     *
     * @param FileBag $bag The filebag to use
     *
     * @return array An array of files
     */
    protected function getFiles(FileBag $bag): array
    {
        $files = [];
        $fileBag = $bag->all();
        $fileIterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($fileBag), \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($fileIterator as $file) {
            if (\is_array($file) || null === $file) {
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }
}