<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller\Action;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Form;

final class RegisterUserActionTest extends WebTestCase
{
    use MailerAssertionsTrait;

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

    public function testIfUserCanRegisterAndSignIn(): void
    {
        $userEmail = 'test@example.com';
        $userPassword = 'test';

        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form();
        $this->fillRegistrationForm($form, $userEmail, $userPassword);

        $this->client->submit($form);

        $this->assertResponseRedirects();
        $this->assertEmailCount(1);

        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, 'Your confirmation link: ');

        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $form = $this->client->getCrawler()->selectButton('Submit')->form();
        $this->fillLoginForm($form, $userEmail, $userPassword);

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertSelectorTextContains('.alert-danger', 'You have to confirm your email');

        /** @var TemplatedEmail $email */
        $activationUrl = $email->getContext()['signedUrl'];
        $this->client->request('GET', $activationUrl);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('.alert-success', 'Your e-mail address has been verified.');
    }

    public function testEmailUniqueValidation()
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['email' => 'user@example.com']);
        $this->assertNotNull($user);

        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('Submit')->form();
        $this->fillRegistrationForm($form, $user->getEmail(), 'test');

        $this->client->submit($form);
        $this->assertSelectorTextContains('.invalid-feedback', 'Email is already used.');
    }

    private function fillRegistrationForm(
        Form   $form,
        string $email,
        string $passwordFirst,
        string $passwordSecond = null
    ): Form
    {
        return $form->setValues([
            'registration_form[email]' => $email,
            'registration_form[password][first]' => $passwordFirst,
            'registration_form[password][second]' => $passwordSecond === null ? $passwordFirst : $passwordSecond
        ]);
    }

    private function fillLoginForm(
        Form $form,
        string $email,
        string $password
    ): Form
    {
        return $form->setValues([
            '_username' => $email,
            '_password' => $password
        ]);
    }
}