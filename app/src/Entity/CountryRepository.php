<?php

namespace App\Entity;

interface CountryRepository
{
    function GetAll(): array;
    function Get(string $code): ?Country;
    function Store(Country $country): void;
    function Edit(string $code, Country $country): void;
    function Delete(string $code): void;
}
