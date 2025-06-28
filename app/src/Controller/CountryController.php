<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Entity\Country;
use App\Entity\CountryScennarios;
use App\Entity\Exceptions\InvalidCodeException;
use App\Entity\Exceptions\CountryNotFoundException;
use App\Entity\Exceptions\DuplicatedCodeException;
use OpenApi\Attributes as OA;

#[OA\Info(title: "Countries API", version: "1.0.0")]
#[OA\Tag(name: "Countries", description: "Управление данными стран")]
#[OA\Server(url: "http://localhost:8080", description: "Локальный сервер разработки")]
#[OA\Server(url: "https://api.myapp.com", description: "Продакшен сервер")]
#[Route('api/country', name: 'app_country')]
final class CountryController extends AbstractController
{
    public function __construct(
        private readonly CountryScennarios $countries
    ) {
    }

    #[OA\Get(
        path: '/api/country',
        summary: 'Получить список всех стран',
        tags: ['Countries'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список стран',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Country')
                )
            )
        ]
    )]
    #[Route('', name: 'app_country_root', methods: ['GET'])]
    public function GetAll(): JsonResponse
    {
        $data[] = $this->countries->SelectAll();
        return $this->json(data: $data, status: 200);
    }

    #[OA\Get(
        path: '/api/country/{code}',
        summary: 'Получить страну по коду',
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'code',
                description: 'Код страны',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Данные страны',
                content: new OA\JsonContent(ref: '#/components/schemas/Country')
            ),
            new OA\Response(
                response: 400,
                description: 'Неверный код страны',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            ),
            new OA\Response(
                response: 404,
                description: 'Страна не найдена',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            )
        ]
    )]
    #[Route('/{code}', name: 'app_country_code', methods: ['GET'])]
    public function GetByCode(string $code): JsonResponse
    {
        try {
            $country = $this->countries->GetByCode($code);
            return $this->json(data: $country);
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    #[OA\Post(
        path: '/api/country',
        summary: 'Добавить новую страну',
        tags: ['Countries'],
        requestBody: new OA\RequestBody(
            description: 'Данные страны',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/Country')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Страна успешно добавлена',
                content: new OA\JsonContent(ref: '#/components/schemas/Country')
            ),
            new OA\Response(
                response: 400,
                description: 'Неверный код страны',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            ),
            new OA\Response(
                response: 409,
                description: 'Код страны уже существует',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            )
        ]
    )]
    #[Route('', name: 'app_country_add', methods: ['POST'])]
    public function Add(#[MapRequestPayload] Country $country): JsonResponse
    {
        try {
            $this->countries->Add(country: $country);
            return $this->json(data: $country, status: 200);
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (DuplicatedCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        }
    }

    #[OA\Delete(
        path: '/api/country/{code}',
        summary: 'Удалить страну',
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'code',
                description: 'Код страны',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Страна успешно удалена'
            ),
            new OA\Response(
                response: 404,
                description: 'Страна не найдена',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            )
        ]
    )]
    #[Route('/{code}', name: 'app_country_del', methods: ['DELETE'])]
    public function Delete(string $code): JsonResponse
    {
        try {
            $this->countries->DeleteByCode($code);
            return $this->json(data: null, status: 204);
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    #[OA\Patch(
        path: '/api/country/{code}',
        summary: 'Обновить данные страны',
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'code',
                description: 'Код страны',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        requestBody: new OA\RequestBody(
            description: 'Новые данные страны',
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/Country')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Данные страны успешно обновлены',
                content: new OA\JsonContent(ref: '#/components/schemas/Country')
            ),
            new OA\Response(
                response: 404,
                description: 'Страна не найдена',
                content: new OA\JsonContent(ref: '#/components/schemas/Error')
            )
        ]
    )]
    #[Route('/{code}', name: 'app_country_edit', methods: ['PATCH'])]
    public function Update(string $code, #[MapRequestPayload] Country $country): JsonResponse
    {
        try {
            $this->countries->UpdateByCode(code: $code, country: $country);
            $updatedCountry = $this->countries->GetByCode($code);
            return $this->json(data: $updatedCountry, status: 200);
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        }
    }

    private function buildErrorResponse(Exception $ex): JsonResponse
    {
        return $this->json(data: [
            'errorCode' => $ex->getCode(),
            'errorMessage' => $ex->getMessage(),
        ]);
    }
}