<?php
namespace App\Entity;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Country',
    title: 'Country',
    description: 'Country entity',
    required: ['shortName', 'fullName', 'isoAlpha2', 'isoAlpha3', 'isoNumeric', 'population', 'square']
)]
class Country
{
    public function __construct(
        #[OA\Property(
            type: 'string',
            example: 'ExampleCountry',
            description: 'Short name of the country'
        )]
        public string $shortName,

        #[OA\Property(
            type: 'string',
            example: 'Dreamland',
            description: 'SuperDuper Dreamland'
        )]
        public string $fullName,

        #[OA\Property(
            type: 'string',
            example: 'DL',
            description: 'alpha-2 country code',
            maxLength: 2,
            minLength: 2
        )]
        public string $isoAlpha2,

        #[OA\Property(
            type: 'string',
            example: 'SDL',
            description: 'alpha-3 country code',
            maxLength: 3,
            minLength: 3
        )]
        public string $isoAlpha3,

        #[OA\Property(
            type: 'integer',
            example: 888,
            description: 'numeric country code'
        )]
        public int $isoNumeric,

        #[OA\Property(
            type: 'integer',
            example: 146599183,
            description: 'Country population'
        )]
        public int $population,

        #[OA\Property(
            type: 'number',
            format: 'float',
            example: 17098242.0,
            description: 'Country area in square kilometers'
        )]
        public float $square
    ) {
    }
}

#[OA\Schema(
    schema: 'Error',
    title: 'Error',
    description: 'Error response',
    required: ['errorCode', 'errorMessage']
)]
class Error
{
    #[OA\Property(
        type: 'integer',
        example: 404,
        description: 'HTTP status code'
    )]
    public int $errorCode;

    #[OA\Property(
        type: 'string',
        example: 'Country not found',
        description: 'Error message'
    )]
    public string $errorMessage;
}
