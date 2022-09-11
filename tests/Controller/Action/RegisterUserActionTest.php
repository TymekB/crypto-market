<?php

declare(strict_types=1);

namespace App\Tests\Controller\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RegisterUserActionTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIfUserCanRegister(): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form();
        $form->setValues([
            'registration_form[email]' => 'test@example.com',
            'registration_form[password][first]' => 'test',
            'registration_form[password][second]' => 'test'
        ]);
        $client->submit($form);

        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }
}