<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testShowProfilEdit()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);

        $client->request('GET', '/profil/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon profil');
    }

    public function testProfilUpdateFirstnameAndLastname()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/profil/edit');

        $form = $crawler->filter('form[name="user_edit_profile"]')->selectButton('Modifier mon profil')->form([
            'user_edit_profile' => [
                'firstname' => 'John2',
                'lastname'  => 'Doe2'
            ]
        ]);

        $client->submit($form);

        $this->assertSelectorTextSame('div.alert.alert-success', 'Votre profil a bien été mis à jour.');
        $this->assertResponseIsSuccessful();
    }

    public function testProfilUpdatePassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/profil/edit');

        $form = $crawler->filter('form[name="user_edit_password"]')->selectButton('Modifier mon mot de passe')->form([
            'user_edit_password' => [
                'password' => [
                    'first'  => 'newpassword',
                    'second' => 'newpassword'
                ]
            ]
        ]);

        $client->submit($form);

        $this->assertSelectorTextSame('div.alert.alert-success', 'Votre mot de passe a bien été mis à jour.');
        $this->assertResponseIsSuccessful();
    }

    public function testProfilUpdatePasswordNotSame()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/profil/edit');

        $form = $crawler->filter('form[name="user_edit_password"]')->selectButton('Modifier mon mot de passe')->form([
            'user_edit_password' => [
                'password' => [
                    'first'  => 'newpassword',
                    'second' => 'badpassword'
                ]
            ]
        ]);


        $client->submit($form);

        $this->assertSelectorTextSame('form[name="user_edit_password"] label[for="user_edit_password_password_first"] span.invalid-feedback span.form-error-message', 'Les mots de passes ne correspondent pas');
        $this->assertResponseIsSuccessful();
    }
}