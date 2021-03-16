<?php

namespace App\Service\VideoService;

class VideoServiceFinder
{
    const YOUTUBE_IFRAME = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/__VIDEOID__" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    const DAILYMOTION_IFRAME = '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/__VIDEO_ID__?autoplay=1" width="100%" height="100%" allowfullscreen allow="autoplay"> </iframe> </div>';
    const VIMEO_IFRAME = '<iframe src="https://player.vimeo.com/video/__VIDEOID__?title=0&byline=0&portrait=0" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

    const YOUTUBE_REGEX = "/(?:http(?:s)?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([^\?&\"'>]+)/";
    const YOUTUBE_SHORT_REGEX = "/(?:http(?:s)?:\/\/)?(?:www\.)?youtu\.be\/([^\?&\"\'>]+)/";

    const DAILYMOTION_REGEX = "/(?:http(?:s)?:\/\/)?(?:www\.)?dailymotion\.com\/video\/([^\?&\"\'>]+)/";
    const DAILYMOTION_SHORT_REGEX = "/(?:http(?:s)?:\/\/)?(?:www\.)?dai\.ly\/([^\?&\"\'>]+)/";

    const VIMEO_REGEX = "/(?:http(?:s)?:\/\/)?(?:www\.)?vimeo\.com\/([0-9]+)/";

    /**
     * @param $url
     * @return string[]
     */
    public function find(string $url)
    {
        $match = false;

        foreach ($this->getRegexGroups() as $groupName => $regexs) {
            foreach ($regexs as $regex) {
                preg_match($regex, $url, $m);

                if (!empty($m)) {

                    $match = [$groupName => $m[1]];
                }
            }
        }

        return $match;
    }

    private function getRegexGroups(): array
    {
        return [
            'youtube'     => [self::YOUTUBE_REGEX, self::YOUTUBE_SHORT_REGEX],
            'dailymotion' => [self::DAILYMOTION_REGEX, self::DAILYMOTION_SHORT_REGEX],
            'vimeo'       => [self::VIMEO_REGEX]
        ];
    }

    /**
     * @param $service
     * @param $videoId
     * @return string
     */
    public static function getIframe(string $service, string $videoId): string
    {
        $serviesIframes = [
            'youtube'     => self::YOUTUBE_IFRAME,
            'dailymotion' => self::DAILYMOTION_IFRAME,
            'vimeo'       => self::VIMEO_IFRAME
        ];

        if (!array_key_exists($service, $serviesIframes)) {
            return false;
        }

        return str_replace('__VIDEOID__', $videoId, $serviesIframes[$service]);
    }
}