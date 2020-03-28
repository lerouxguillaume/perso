<?php

namespace App\Controller;

use App\Entity\Document;
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
    public function postDocument(Request $request)
    {
        $tmpFile = $request->files->get('uploadedFile');
        $document = $this->fileUploader->uploadFile($tmpFile, $this->getUser());

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return $this->handleView(
            $this->view(
                [
                    'status' => 'ok',
                ],
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @Get(path="/documents")
     * @View
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getDocuments()
    {
        return $this->entityManager->getRepository(Document::class)->findAll();
    }

    /**
     * @Get(path="/document/{id}")
     * @View
     * @param int $id
     * @return object|null
     */
    public function getDocument(int $id)
    {
        /** @var Document $document */
        $document = $this->entityManager->getRepository(Document::class)->find($id);

        if (empty($document)) {
            throw new NotFoundHttpException();
        }
        return $document;
    }

    /**
     * @Get(path="/download/{id}")
     * @View
     * @param int $id
     * @return object|null
     */
    public function downloadDocument(int $id)
    {
        /** @var Document $document */
        $document = $this->entityManager->getRepository(Document::class)->find($id);

        if (empty($document)) {
            throw new NotFoundHttpException();
        }
//        dump($document->getFilePath());die();
        return new BinaryFileResponse(stripslashes($document->getFilePath()));
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