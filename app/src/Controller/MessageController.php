<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MessageHelper;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class MessageController extends AbstractController
{


    public function __construct(private readonly MessageHelper $messageHelper)
    {}

    #[Route('/hello', name: 'hello', methods: ['GET'])]
    public function welcomeMessage(): Response
    {
        return $this->json([
            'data' => $this->messageHelper->setTextMessage('hello')->getMessage(),
        ]);
    }

    #[Route('/howareyou', name: 'howareyou', methods: ['GET'])]
    public function feelingsMessage(): Response
    {
        return $this->json([
            'data' => $this->messageHelper->setTextMessage('howareyou')->getMessage(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/whattimeisit', name: 'whattimeisit', methods: ['GET'])]
    public function timeMessage(): Response
    {
        return $this->json([
            'data' => $this->messageHelper->setTimeMessage()->getMessage(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/whattimeisit/in/{city}', name: 'get_whattimeisit_in', methods: ['GET'])]
    public function getTimeMessage(string $city): Response
    {
        return $this->json([
            'data' => $this->messageHelper->setTimeMessage($city)->getMessage(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/whattimeisit/in', name: 'post_whattimeisit_in', methods: ['POST'])]
    public function postTimeMessage(Request $request, LoggerInterface $logger): Response
    {
        $apiKey = $request->headers->get('X-API-KEY');
        $logger->info('API Key received in MessageController: ' . $apiKey);

        $data = json_decode($request->getContent(), true);

        if (isset($data['city'])) {
            return $this->json([
                'data' => $this->messageHelper->setTimeMessage($data['city'])->getMessage(),
            ]);
        } else {
            return $this->json([
                'error' => 'A city was not provided in the request!'
            ], 400);
        }

    }
}
