<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     * @param $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function provideUrls(): array
    {
        return [
            ['/'],
            ['/login'],
            ['/register'],
            ['/tricks'],
            ['/tricks/grabs'],
            ['/tricks/grabs/indy'],
            ['/password/reset']
        ];
    }
}