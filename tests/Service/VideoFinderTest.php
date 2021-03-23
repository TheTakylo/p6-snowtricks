<?php

namespace App\Tests\Service;

use App\Service\VideoService\VideoServiceFinder;
use PHPUnit\Framework\TestCase;

class VideoFinderTest extends TestCase
{
    public function testMatchYoutube()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("https://www.youtube.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("https://youtube.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("youtube.com/watch?v=hXRt-Pb_Z04"));
    }

    public function testYoutubeWithoutVideoId()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.youtube.com/watch?v"));
        $this->assertEquals(false, $videoServiceFinder->find("https://youtube.com/watch?v"));
        $this->assertEquals(false, $videoServiceFinder->find("youtube.com/watch?v"));
    }

    public function testNotMatchYoutube()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.youtubee.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(false, $videoServiceFinder->find("https://youtubee.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(false, $videoServiceFinder->find("youtubee.com/watch?v=hXRt-Pb_Z04"));
    }

    public function testMatchDailymotion()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("https://www.dailymotion.com/video/xiawfb"));
        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("https://dailymotion.com/video/xiawfb"));
        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("dailymotion.com/video/xiawfb"));
    }

    public function testDailymotionWithoutVideoId()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.dailymotion.com/video/"));
        $this->assertEquals(false, $videoServiceFinder->find("https://dailymotion.com/video/"));
        $this->assertEquals(false, $videoServiceFinder->find("dailymotion.com/video/"));
    }

    public function testNotMatchDailymotion()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.dailymotionn.com/video/"));
        $this->assertEquals(false, $videoServiceFinder->find("https://dailymotionn.com/video/"));
        $this->assertEquals(false, $videoServiceFinder->find("dailymotionn.com/video/"));
    }

    public function testMatchVimeo()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("https://www.vimeo.com/521788482"));
        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("https://vimeo.com/521788482"));
        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("vimeo.com/521788482"));
    }

    public function testVimeoWithoutVideoId()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.vimeo.com/"));
        $this->assertEquals(false, $videoServiceFinder->find("https://vimeo.com/"));
        $this->assertEquals(false, $videoServiceFinder->find("vimeo.com/"));
    }

    public function testNotMatchVimeo()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(false, $videoServiceFinder->find("https://www.vimeoo.com/"));
        $this->assertEquals(false, $videoServiceFinder->find("https://vimeoo.com/"));
        $this->assertEquals(false, $videoServiceFinder->find("vimeoo.com/"));
    }
}