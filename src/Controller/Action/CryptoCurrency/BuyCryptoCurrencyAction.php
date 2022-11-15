<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\API\Binance\CryptoCurrencyManagerInterface;
use App\Entity\User;
use App\Form\Type\CryptoCurrencyFormType;
use App\Message\Command\BuyCryptoCurrencyCommand;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class BuyCryptoCurrencyAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function __invoke(Request $request, UserInterface $user, string $symbol): Response
    {
        $form = $this->formFactory->create(CryptoCurrencyFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->get('quantity')->getData();
            /** @var User $user */
            $userId = $user->getId();

            $this->messageBus->dispatch(
                new BuyCryptoCurrencyCommand($symbol, $quantity, $userId)
            );
        }

        $cryptoCurrencyPrice = $this->cryptoCurrencyManager
            ->getCryptoCurrency($symbol)
            ->getLastPrice();

        return new Response(
            $this->twig->render('cryptocurrency/buy.html.twig', [
                'symbol' => $symbol,
                'price' => $cryptoCurrencyPrice,
                'form' => $form->createView()
            ])
        );
    }
}