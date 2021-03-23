<?php

namespace App\Tests\Controller;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickControllerTest extends WebTestCase
{
    public function testListTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Toutes les figures');
        $this->assertSelectorNotExists('.container .bg-light h5.mt-3');
    }

    public function testListTricksCategory()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/grabs');

        $this->assertResponseIsSuccessful();
    }

    public function testListTricksCategoryThatNotExist()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/notexisting');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShowTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/grabs/indy');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('.bg-light > .container > h1.py-4', 'Indy');
    }

    public function testShowTrickThatNotExist()
    {
        $client = static::createClient();
        $client->request('GET', '/tricks/grabs/notexisting');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testAddTrick()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        /** @var TrickCategory $trickCategory */
        $trickCategory = static::$container->get(TrickCategoryRepository::class)->findOneBy(['name' => 'Grabs']);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tricks/new');

        $form = $crawler->filter('form[name="trick"] div.mt-5')->selectButton('Sauvegarder')->form([
            'trick' => [
                'name'          => 'Titre de la figure',
                'trickCategory' => $trickCategory->getId(),
                'description'   => "Description de la figure"
            ]
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/tricks/grabs/titre-de-la-figure', 302);

        $client->followRedirect();

        $this->assertSelectorTextSame('.bg-light > .container > h1.py-4', 'Titre de la figure');
    }

    public function testEditTrick()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        /** @var Trick $trick */
        $trick = static::$container->get(TrickRepository::class)->findOneBy(['name' => 'Indy']);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tricks/edit/' . $trick->getId());

        $form = $crawler->filter('form[name="trick"] div.mt-5')->selectButton('Sauvegarder')->form([
            'trick' => [
                'name' => 'Titre de la figure modifié',
            ]
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/tricks/grabs/titre-de-la-figure-modifie', 302);

        $client->followRedirect();

        $this->assertSelectorTextSame('.bg-light > .container > h1.py-4', 'Titre de la figure modifié');
    }
}