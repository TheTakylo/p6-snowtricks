<?php

namespace App\Service\VideoService\Twig;

use App\Entity\Video;
use App\Service\VideoService\VideoServiceFinder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VideoServiceExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('videoServiceIframe', [$this, 'getIframe'], ['is_safe' => ['html']]),
        ];
    }

    public function getIframe(Video $video)
    {
        return VideoServiceFinder::getIframe($video->getPlatform(), $video->getVideoId());
    }
}