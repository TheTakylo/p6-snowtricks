<?php

namespace App\Listener\Doctrine;

use App\Entity\Video;
use App\Service\VideoService\VideoServiceFinder;

class VideoListener
{
    /** @var VideoServiceFinder */
    private $videoServiceFinder;

    public function __construct(VideoServiceFinder $videoServiceFinder)
    {
        $this->videoServiceFinder = $videoServiceFinder;
    }

    public function prePersist(Video $video)
    {
        $match = $this->videoServiceFinder->find($video->getUrl());

        if (!empty($match)) {
            $video->setPlatform(array_keys($match)[0]);
            $video->setVideoId(array_values($match)[0]);
        }
    }
}