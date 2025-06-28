<?php

namespace App\Entity;
use App\Entity\Countrystoragesitory;
use App\Entity\Exceptions\InvalidCodeException;
use App\Entity\Exceptions\CountryNotFoundException;
use App\Entity\Exceptions\DuplicatedCodeException;
class CountryScennarios
{
    public function __construct(
        private readonly CountryRepository $repo
    ) {
    }
    
    public function SelectAll(): array{
         return $this->repo->GetAll();
    }
    public function GetByCode(string $code): ?Country{
         $country = $this->repo->Get($code);
        if ($country === null) {
            throw new CountryNotFoundException($code);
        }
        return $country;
    }
    public function Add(Country $country): void{
        // выполнить проверку корректности кода
        if (!$this->validate2(code: $country->isoAlpha2) && !$this->validate3(code: $country->isoAlpha3)
            && !$this->validateInt(code: $country->isoNumeric)) {
            throw new InvalidCodeException(
                message: 'validation failed',
            );
        }

        // выполнить проверку уникальности кода
        $code2 = $this->repo->Get(code: $country->isoAlpha2);
        $code3 = $this->repo->Get(code: $country->isoAlpha3);
        $codeInt = $this->repo->Get(code: $country->isoNumeric);
        if ($code2 != null || $code3 != null || $codeInt != null) {
            throw new DuplicatedCodeException();
        }
        // если все ок, то сохранить
        $this->repo->Store(country: $country);
    }
    public function UpdateByCode(string $code, Country $country): void{
        
        // выполнить проверку наличия 
        $updatedCountry = $this->repo->Get(code: $code);
        if ($updatedCountry === null) {
            throw new CountryNotFoundException(notFoundCode: $code);
        }
       
        // если все ок, то сделать update
        $this->repo->Edit(code: $code, country: $country);
    }
    public function DeleteByCode(string $code): void{
         $country = $this->repo->Get(code: $code);
        if ($country === null) {
            throw new CountryNotFoundException(notFoundCode: $code);
        }
        $this->repo->Delete(code: $code);
    }

    private function validate3(string $code): bool {
        // ^[A-Z]{3}$
        return preg_match(pattern: '/^[A-Z]{3}$/', subject: $code);
    }
    private function validate2(string $code): bool {
        // ^[A-Z]{2}$
        return preg_match(pattern: '/^[A-Z]{2}$/', subject: $code);
    }
    private function validateInt(int $code): bool {
        // ^[0-9]{3}$
        return preg_match(pattern: '/^[0-9]{3}$/', subject: $code);
    }
}
