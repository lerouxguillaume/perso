<?php

namespace App\Service;

use App\Entity\Documents\Video;
use App\Entity\Documents\VideoFactory;
use FFMpeg\FFProbe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class VideoService
 * @package App\Service
 */
class VideoService
{
    /** @var string */
    private $path;
    /** @var UrlGeneratorInterface */
    private $router;

    /**
     * FetchApiNasa constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath, UrlGeneratorInterface $router)
    {
        $this->path = $filePath;
        $this->router = $router;
    }

    /**
     * @param string $path
     * @param string $name
     * @return Video
     * @throws \Exception
     */
    public function addVideo(string $path, string $name)
    {
        $video = $this->addVideoFile($path);

        $ffmprobe = FFProbe::create();
        $duration = $ffmprobe->format($video->getFilePath())->get('duration');

        $video
            ->setDuration($duration)
            ->setName($name)
        ;

        return $video;
    }

    /**
     * @param string $path
     * @return string
     * @throws \Exception
     */
    private function prepareVideo(string $path)
    {
        $ffmprobe = FFProbe::create();
        $format = $ffmprobe->format($path)->get('format_name');
        $resultFilename = $this->getEncodedFilename() . '.mp4';

        if (strpos($format, 'mp4') === false) {
//        $format = new X264();
//        $format->on('progress', function ($video, $format, $percentage) {
//            echo "$percentage % transcoded";
//        });
//        $ffmpeg = FFMpeg::create();
//        $video = $ffmpeg->open($path);
//        $video->save(new X264('aac'), self::FILE_PATH.$resultFilename);

            exec('/usr/bin/ffmpeg -y -i \'' . $path . '\' ' . $this->path . $resultFilename, $out, $res);
            if ($res != 0) {
                error_log(var_export($out, true));
                error_log(var_export($res, true));

                throw new \Exception("Error!");
            }

        } else {
            copy($path, $this->path . $resultFilename);
        }

        return $resultFilename;
    }

    /**
     * @param string $path
     * @return Video
     * @throws \Exception
     */
    public function addVideoFile(string $path)
    {
        $videoFilename = $this->prepareVideo($path);
        $video = new Video();
        $video
            ->setFileName($videoFilename)
            ->setUploadedAt(new \DateTime())
            ->setPath($this->path)
        ;

        return $video;
    }

    public function generateUrl(Video $video)
    {
        return $this->router->generate('videoDownload', ['id' => $video->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @return string
     */
    private function getEncodedFilename() : string
    {
        return uniqid('episode_');
    }
}