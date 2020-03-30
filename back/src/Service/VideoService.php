<?php

namespace App\Service;

use App\Entity\Documents\Video;
use App\Entity\Documents\VideoFactory;
use FFMpeg\FFProbe;

/**
 * Class VideoService
 * @package App\Service
 */
class VideoService
{
    const FILE_PATH = '/tmp/';

    /**
     * @param string $path
     * @param string $name
     * @param int $videoType
     * @return Video
     * @throws \Exception
     */
    public function addVideo(string $path, string $name, int $videoType)
    {
        $video = $this->addVideoFile($path, $videoType);

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

            exec('/usr/bin/ffmpeg -y -i \'' . $path . '\' ' . self::FILE_PATH . $resultFilename, $out, $res);
            if ($res != 0) {
                error_log(var_export($out, true));
                error_log(var_export($res, true));

                throw new \Exception("Error!");
            }

        } else {
            copy($path, self::FILE_PATH . $resultFilename);
        }

        return $resultFilename;
    }

    /**
     * @param string $path
     * @param int $videoType
     * @return Video
     * @throws \Exception
     */
    public function addVideoFile(string $path, int $videoType)
    {
        $videoFilename = $this->prepareVideo($path);
        $video = VideoFactory::Video($videoType);
        $video
            ->setFileName($videoFilename)
            ->setUploadedAt(new \DateTime())
            ->setPath(self::FILE_PATH)
        ;

        return $video;
    }

    /**
     * @return string
     */
    private function getEncodedFilename() : string
    {
        return uniqid('episode_');
    }
}