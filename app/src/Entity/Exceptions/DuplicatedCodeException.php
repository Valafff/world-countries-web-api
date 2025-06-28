<?php

namespace App\Entity\Exceptions;

use Throwable;
use Exception;

// DuplicatedCodeException - исключение дублирующегося кода страны
class DuplicatedCodeException extends Exception {

    // переопределение конструктора исключения
    public function __construct(Throwable $previous = null) {
        $exceptionMessage = "some country code is duplicated";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::DUPLICATED_CODE_ERROR,
            previous: $previous,
        );
    }
}