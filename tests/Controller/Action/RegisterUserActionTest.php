<?php

declare(strict_types=1);

namespace App\Tests\Controller\Action;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

final class RegisterUserActionTest extends WebTestCase
{
    private readonly AbstractBrowser $client;
    private EntityRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createClient();
        $this->userRepository = self::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getRepository(User::class);
    }

    public function testIfUserCanRegister(): void
    {
        $crawler = $this->client->request('GET', '/register');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form();
        $form->setValues([
            'registration_form[email]' => 'test@example.com',
            'registration_form[password][first]' => 'test',
            'registration_form[password][second]' => 'test'
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects();

        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testEmailUniqueValidation()
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['email' => 'user@example.com']);
        $this->assertNotNull($user);

        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('Submit')->form();
        $form->setValues([
            'registration_form[email]' => $user->getEmail(),
            'registration_form[password][first]' => 'test',
            'registration_form[password][second]' => 'test'
        ]);

        $this->client->submit($form);
        $this->assertSelectorTextContains('.invalid-feedback', 'Email is already used.');
    }
}