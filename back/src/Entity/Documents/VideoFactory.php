<?php

namespace App\Entity\Documents;

use App\Enum\DocumentEnum;
use LogicException;

final class VideoFactory
{
    public static function Video(int $videoCode)
    {
        switch ($videoCode) {
            case DocumentEnum::EPISODE_TYPE:
                return new Episode();
            case DocumentEnum::MOVIE_TYPE:
                return new Movie();
        }
        throw new LogicException($videoCode . ' is not a valid Video code');
    }
}