<?php


namespace App\Service;


use App\Entity\Document;
use App\Entity\Security\User;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Media\Video;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    const FILE_PATH = '/tmp/';

    /**
     * @param UploadedFile $uploadedFile
     * @param User|null $user
     * @return Document
     * @throws \Exception
     */
    public function uploadFile(UploadedFile $uploadedFile, ?User $user)
    {
        $document = new Document();
        $document
            ->setName($uploadedFile->getClientOriginalName())
            ->setFileName($this->getEncodedFilename().'.mp4')
            ->setPath(self::FILE_PATH)
            ->setPrivate(false)
            ->setUploadedAt(new \DateTime())
            ;
        exec('/usr/bin/ffmpeg -y -i '.$uploadedFile->getPathname().' '.$document->getFilePath(), $out, $res);
        if($res != 0) {
            error_log(var_export($out, true));
            error_log(var_export($res, true));

            throw new \Exception("Error!");
        }
//        $ffmpeg = FFMpeg::create();
//        $video = $ffmpeg->open($document->getFilePath());
//        dump($video);die();
//        $video->save(new X264('aac'), $document->getFilePath());

        return $document;
    }

    private function getEncodedFilename() : string
    {
        return uniqid('file_');
    }
}