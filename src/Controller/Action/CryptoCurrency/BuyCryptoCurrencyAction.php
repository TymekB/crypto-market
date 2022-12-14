<?php

declare(strict_types=1);

namespace App\Controller\Action\CryptoCurrency;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Dto\BuyCryptoCurrencyDto;
use App\Entity\User;
use App\Form\Type\CryptoCurrencyFormType;
use App\Message\Command\BuyCryptoCurrencyCommand;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;

final class BuyCryptoCurrencyAction
{
    public function __construct(
        private readonly Environment $twig,
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly MessageBusInterface $messageBus,
        private readonly RouterInterface $router,
    )
    {
    }

    public function __invoke(Request $request, UserInterface $user, string $symbol): Response
    {
       /** @var User $user */

        $cryptoCurrencyPrice = $this->cryptoCurrencyManager
            ->getCryptoCurrency($symbol)
            ->getLastPrice();

        $cryptoCurrencyDto = new BuyCryptoCurrencyDto();
        $cryptoCurrencyDto->setUserBalance($user->getBalance());

        $form = $this->formFactory->create(CryptoCurrencyFormType::class, $cryptoCurrencyDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $quantity = $cryptoCurrencyDto->getQuantity();
            $userId = $user->getId();

            $this->messageBus->dispatch(
                new BuyCryptoCurrencyCommand($symbol, $quantity, $userId)
            );

            return new RedirectResponse($this->router->generate('dashboard'));
        }

        return new Response(
            $this->twig->render('cryptocurrency/buy.html.twig', [
                'symbol' => $symbol,
                'price' => $cryptoCurrencyPrice,
                'balance' => $user->getBalance(),
                'form' => $form->createView()
            ])
        );
    }
}