<?php

namespace App\Entity\Exceptions;

use Throwable;
use Exception;

// InvalidCodeException - исключение невалидного кода страны
class InvalidCodeException extends Exception {

    // переопределение конструктора исключения
    public function __construct($message, Throwable $previous = null) {
        $exceptionMessage = "some country code is invalid: ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::INVALID_CODE_ERROR,
            previous: $previous,
        );
    }
}
