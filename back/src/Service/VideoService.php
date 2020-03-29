<?php

namespace App\Service;

use App\Entity\Serie;
use App\Entity\Video;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;

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
     * @param int|null $episode
     * @param Serie|null $serie
     * @return Video
     * @throws \Exception
     */
    public function addVideo(string $path, string $name, int $episode = null)
    {
        $video = $this->addVideoFile($path);

        $ffmprobe = FFProbe::create();
        $duration = $ffmprobe->format($video->getFilePath())->get('duration');

        $video
            ->setDuration($duration)
            ->setEpisode($episode)
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