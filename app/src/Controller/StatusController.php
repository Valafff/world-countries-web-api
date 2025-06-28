<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Test API",
    version: "1.0.0",
    description: "API для проверки статуса сервера",
    contact: new OA\Contact(email: "support@api.com"),
    license: new OA\License(name: "MIT", url: "https://opensource.org/licenses/MIT")
)]
#[OA\Server(url: "http://localhost:8080", description: "Локальная среда разработки")]
#[OA\Server(url: "https://api.example.com", description: "Продакшен сервер")]
#[OA\Tag(name: "Status", description: "Проверка состояния сервера")]
#[OA\Tag(name: "Ping", description: "Проверка доступности API")]
final class StatusController extends AbstractController
{
    #[Route('/', name: 'app_status', methods: ['GET'])]
    #[OA\Get(
        path: '/',
        summary: 'Проверка статуса сервера',
        description: 'Возвращает текущее состояние сервера',
        tags: ['Status'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешный ответ',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/StatusResponse'
                )
            )
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $data = [
            'status' => 'server is running',
            'host' => $request->getHost(),
            'protocol' => $request->getScheme(),
            'timestamp' => (new \DateTime())->format(\DateTimeInterface::ATOM)
        ];
    
        return new JsonResponse($data);
    }

    #[Route('/ping', name: 'api_ping', methods: ['GET'])]
    #[OA\Get(
        path: '/ping',
        summary: 'Ping endpoint',
        description: 'Простая проверка доступности API',
        tags: ['Ping'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешный ответ',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/PingResponse'
                )
            )
        ]
    )]
    public function ping(): JsonResponse
    {
        return $this->json([
            'message' => 'pong',
            'timestamp' => (new \DateTime())->format(\DateTimeInterface::ATOM)
        ]);
    }
}


#[OA\Schema(
    schema: 'StatusResponse',
    title: 'StatusResponse',
    description: 'Статус сервера',
    required: ['status', 'host', 'protocol', 'timestamp']
)]
class StatusResponse
{
    #[OA\Property(
        type: 'string',
        example: 'server is running',
        description: 'Статус сервера'
    )]
    public string $status;

    #[OA\Property(
        type: 'string',
        example: 'localhost',
        description: 'Хост сервера'
    )]
    public string $host;

    #[OA\Property(
        type: 'string',
        example: 'http',
        description: 'Используемый протокол'
    )]
    public string $protocol;

    #[OA\Property(
        type: 'string',
        format: 'date-time',
        example: '2023-05-15T12:00:00+00:00',
        description: 'Временная метка ответа'
    )]
    public string $timestamp;
}

#[OA\Schema(
    schema: 'PingResponse',
    title: 'PingResponse',
    description: 'Ответ на ping-запрос',
    required: ['message', 'timestamp']
)]
class PingResponse
{
    #[OA\Property(
        type: 'string',
        example: 'pong',
        description: 'Ответное сообщение'
    )]
    public string $message;

    #[OA\Property(
        type: 'string',
        format: 'date-time',
        example: '2023-05-15T12:00:00+00:00',
        description: 'Временная метка ответа'
    )]
    public string $timestamp;
}