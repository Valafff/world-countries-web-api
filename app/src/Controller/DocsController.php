<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class DocsController extends AbstractController
{
        #[Route('/docs', name: 'api_docs')]
        public function index(): Response
        {
            return new Response(file_get_contents(__DIR__ . '/../../public/docs/index.html'));
        }

        #[Route('/swagger-ui.css', name: 'swagger_css')]
    public function swaggerCss(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/swagger-ui.css'),
            200,
            ['Content-Type' => 'text/css']
        );
    }

    #[Route('/swagger-ui-standalone-preset.js', name: 'swagger_standalone_js')]
    public function swaggerStandaloneJs(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/swagger-ui-standalone-preset.js'),
            200,
            ['Content-Type' => 'application/javascript']
        );
    }

    #[Route('/swagger-ui-bundle.js', name: 'swagger_bundle_js')]
    public function swaggerBundleJs(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/swagger-ui-bundle.js'),
            200,
            ['Content-Type' => 'application/javascript']
        );
    }

    #[Route('/index.css', name: 'index_css')]
    public function indexCss(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/index.css'),
            200,
            ['Content-Type' => 'text/css']
        );
    }

    #[Route('/swagger-initializer.js', name: 'swagger_initializer')]
    public function swaggerInitializer(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/swagger-initializer.js'),
            200,
            ['Content-Type' => 'application/javascript']
        );
    }

    #[Route('/favicon-32x32.png', name: 'favicon_32')]
    public function favicon32(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/favicon-32x32.png'),
            200,
            ['Content-Type' => 'image/png']
        );
    }

    #[Route('/favicon-16x16.png', name: 'favicon_16')]
    public function favicon16(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../../public/docs/favicon-16x16.png'),
            200,
            ['Content-Type' => 'image/png']
        );
    }

}