<?php

namespace App\Controller;

use App\Dto\GetCompanyPricesByDatesDto;
use App\Repository\Interface\SymbolRepositoryInterface;
use App\Request\GetCompanyPrices;
use App\Services\FinanceService\FinanceServiceInterface;
use App\Services\Notification\Dto\NotifierDto;
use App\Services\Notification\NotificationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly FinanceServiceInterface $financeService,
        private readonly NotificationServiceInterface $notificationService,
        private readonly SymbolRepositoryInterface $symbolRepository,
    ) {
    }

    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route(path: '/prices', name: 'home.get_prices', methods: ['POST'])]
    public function getPrices(Request $request, ValidatorInterface $validator, Serializer $jsonSerializer)
    {
        $entity = GetCompanyPrices::createFromRequest($request);
        $errors = $entity->validate($validator);

        if ($errors->count() > 0) {
            foreach ($errors as $error) {
                $this->addFlash($error->getPropertyPath(), $error->getMessage());
            }

            return $this->redirectToRoute('home');
        }

        $symbol = $this->symbolRepository->findBySymbol($entity->getSymbol());

        $dto = new GetCompanyPricesByDatesDto(
            symbol: $request->request->get('symbol'),
            startDate: new \DateTime($request->request->get('startDate')),
            endDate: new \DateTime($request->request->get('endDate')),
        );

        $prices = $this->financeService->getCompanyPricesByDates($dto);

        $notifierDto = new NotifierDto(
            $this->getParameter('test_mailer_to'),
            sprintf('From %s to %s', $entity->getStartDate(), $entity->getEndDate()),
            $this->getParameter('mailer_from'),
            $symbol->getCompanyName()
        );

        $this->notificationService->notify($notifierDto);

        return $this->render('prices.html.twig', [
            'prices' => $prices,
            'json_prices' => $jsonSerializer->serialize($prices, 'json'),
        ]);
    }
}
