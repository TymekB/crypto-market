<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Dto\SellCryptoCurrencyDto;
use App\Entity\CryptoCurrency;
use App\Entity\User;
use App\Exception\User\CryptoCurrency\UserCryptoCurrencyNotFound;
use App\Form\Type\CryptoCurrencyFormType;
use App\Message\Command\SellCryptoCurrencyCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class SellCryptoCurrencyAction
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager,
        private readonly Environment $twig,
        private readonly RouterInterface $router,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function __invoke(Request $request,  $symbol, UserInterface $user)
    {
        /** @var User $user */
        /** @var CryptoCurrency $userCryptoCurrency */
        $userCryptoCurrency = $this->entityManager
            ->getRepository(CryptoCurrency::class)
            ->findOneBy(['symbol' => $symbol, 'user' => $user]);

        if(!$userCryptoCurrency) {
            throw new UserCryptoCurrencyNotFound();
        }

        $sellCryptoCurrencyDto = new SellCryptoCurrencyDto();
        $sellCryptoCurrencyDto->setUserQuantity($userCryptoCurrency->getQuantity());

        $form = $this->formFactory->create(CryptoCurrencyFormType::class, $sellCryptoCurrencyDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $quantity = $sellCryptoCurrencyDto->getQuantity();
            $userId = $user->getId();

            $this->messageBus->dispatch(
                new SellCryptoCurrencyCommand($symbol, $quantity, $userId)
            );

            return new RedirectResponse($this->router->generate('dashboard'));
        }

        $binanceCryptoCurrency = $this->cryptoCurrencyManager->getCryptoCurrency($symbol);

        return new Response(
            $this->twig->render('cryptocurrency/sell.html.twig', [
                'binanceCryptoCurrency' => $binanceCryptoCurrency,
                'userCryptoCurrency' => $userCryptoCurrency,
                'form' => $form->createView()
            ])
        );
    }
}