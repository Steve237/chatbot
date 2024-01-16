<?php

namespace App\Controller;

use App\Client\ChatGptClient;
use App\Entity\Conversation;
use App\Repository\VerbatimRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChatbotController extends AbstractController
{
    #[Route('/chatbot', name: 'chatbot')]
    public function index(): Response
    {
        return $this->render('chatbot.html.twig');
    }

    #[Route('/chatbot-iframe', name: 'chatbot_iframe')]
    public function chatbot(): Response
    {
        return $this->render('chatbot_iframe.html.twig');
    }


    #[Route('/chatbot-response', name: 'chatbot_response')]
    public function chatbotResponse(
        ChatGptClient $chatGptClient,
        VerbatimRepository $verbatimRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {

        $message = $request->request->get('messageValue');
        $customerInput = trim(preg_replace('/[^a-zA-Z0-9\'\s]/', '', $message));

        $verbatims = $verbatimRepository->findAll();
        $content = null;

        foreach ($verbatims as $verbatim) {
            $title = trim(preg_replace('/[^a-zA-Z0-9\'\s]/', '', $verbatim->getTitle()));

            if (
                strpos(strtolower($title), strtolower($customerInput)) !== false ||
                strpos(strtolower($customerInput), strtolower($title)) !== false
            ) {
                $content = $verbatim->getContent();
            }
        }

        if (null === $content) {
            $chatBotResponse = "Aucune réponse n'a été trouvée pour votre question, veuillez en poser une autre.";
        } else {

            $question = $message . ". Veuillez répondre en vous basant sur la norme IS0 19011 et le texte suivant: " . $content;
            $response = $chatGptClient->generateResponse($question);
            $response = $response->toArray();
            $chatBotResponse = $response['choices'][0]['message']['content'];

            $conversation = new Conversation();
            $conversation->setQuestion($message);
            $conversation->setResponse($chatBotResponse);

            $entityManager->persist($conversation);
            $entityManager->flush();
        }

        return new JsonResponse(['message' => $chatBotResponse]);
    }
}
