<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->selectButton('Se connecter')->form([
            'email'    => 'admin@admin.fr',
            'password' => 'admin'
        ]);


        $client->submit($form);
        $this->assertResponseRedirects('/', 302);
        $client->followRedirect();

        $this->assertSelectorTextSame('.container > .row > .col-md-6 h1', 'Bienvenue sur SnowTricks');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->selectButton('Se connecter')->form([
            'email'    => 'admin@admin.fr',
            'password' => 'badpassword'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/login', 302);
        $client->followRedirect();

        $this->assertSelectorTextSame('form > div.alert.alert-danger', 'Identifiants invalides.');
        $this->assertResponseIsSuccessful();
    }

    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->filter('form[name="user_registration"]')->selectButton('S\'inscrire')->form([
            'user_registration' => [
                'email'    => 'jdoe@admin.fr',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'password' => 'password'
            ]
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/login', 302);
        $client->followRedirect();

        $this->assertSelectorTextSame('.container > .row > .col-md-6 div.alert.alert-success', 'Un lien d\'activation a été envoyé à l\'adresse email indiqué');
        $this->assertResponseIsSuccessful();
    }

    public function testRegisterWithExistingEmail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->filter('form[name="user_registration"]')->selectButton('S\'inscrire')->form([
            'user_registration' => [
                'email'    => 'admin@admin.fr',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'password' => 'password'
            ]
        ]);

        $client->submit($form);

        $this->assertSelectorTextSame('form[name="user_registration"] label[for="user_registration_email"] span.invalid-feedback span.form-error-message', 'Cette valeur est déjà utilisée.');
        $this->assertResponseIsSuccessful();
    }
}