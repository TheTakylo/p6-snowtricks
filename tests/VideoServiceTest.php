<?php

namespace App\Tests;

use App\Service\VideoServiceFinder;
use PHPUnit\Framework\TestCase;

class VideoServiceTest extends TestCase
{
    public function testMatchYoutube()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("https://www.youtube.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("https://youtube.com/watch?v=hXRt-Pb_Z04"));
        $this->assertEquals(['youtube' => 'hXRt-Pb_Z04'], $videoServiceFinder->find("youtube.com/watch?v=hXRt-Pb_Z04"));
    }

    public function testMatchDailymotion()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("https://www.dailymotion.com/video/xiawfb"));
        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("https://dailymotion.com/video/xiawfb"));
        $this->assertEquals(['dailymotion' => 'xiawfb'], $videoServiceFinder->find("dailymotion.com/video/xiawfb"));
    }

    public function testMatchVimeo()
    {
        $videoServiceFinder = new VideoServiceFinder();

        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("https://www.vimeo.com/521788482"));
        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("https://vimeo.com/521788482"));
        $this->assertEquals(['vimeo' => '521788482'], $videoServiceFinder->find("vimeo.com/521788482"));
    }
}