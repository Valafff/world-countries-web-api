<?php

namespace App\Rdb;
use App\Entity\Country;
use App\Entity\CountryRepository;
use RuntimeException;
use Exception;
class CountryStorage implements CountryRepository
{
    public function __construct(
        private readonly SqlHelper $conn
    ) {
       $conn->pingDb();
    }
    public function GetAll(): array{
        try {
            // создать подключение к БД
            $conn = $this->conn->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT short_name_f, full_name_f, isoAlpha2_f, isoAlpha3_f, isoNumeric_f, population_f, square_f
                FROM country_t;';
            // выполнить запрос
            $rows = $conn->query(query: $queryStr);
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                $country = new Country(

                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: intval(value: $row[4]),
                    population: intval(value: $row[5]),
                    square: floatval(value: $row[6])
                );
                array_push($countries, $country);

            }
            // вернуть результат
            return $countries;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
    public function Get(string $code): ?Country{
        try {
            // создать подключение к БД
            $conn = $this->conn->openDbConnection();
            //WHERE
            $param = "isoAlpha3_f";
            $bind = "s";
            if(intval($code)){
                $param = "isoNumeric_f";
                $bind = "i";
            }
            else {
                if(mb_strlen($code)===2) $param = "isoAlpha2_f";
                elseif (mb_strlen($code)===3) $param = "isoAlpha3_f";
            }
            // подготовить строку запроса
            $queryStr = 'SELECT short_name_f, full_name_f, isoAlpha2_f, isoAlpha3_f, isoNumeric_f, population_f, square_f
                FROM country_t
                WHERE '.$param.' = ?';
            // подготовить запрос
            $query = $conn->prepare(query: $queryStr);
            $query->bind_param($bind, $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            while ($row = $rows->fetch_array()) {
                // если есть результат - вернем его
                return $country = new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: intval(value: $row[4]),
                    population: intval(value: $row[5]),
                    square: floatval($row[6])
                );
            }
            // иначе вернуть null
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
    public function Store(Country $country): void{
        try {
            // создать подключеник к БД
            $conn = $this->conn->openDbConnection();
            // подготовить запрос INSERT
            $queryStr = 'INSERT INTO country_t (short_name_f, full_name_f, isoAlpha2_f, isoAlpha3_f, isoNumeric_f, population_f, square_f)
                VALUES (?, ?, ?, ?, ?, ?, ?);';
            // подготовить запрос
            $query = $conn->prepare(query: $queryStr);
            $query->bind_param(
                'ssssiid', 
                $country->shortName,
                $country->fullName,
                $country->isoAlpha2,
                $country->isoAlpha3,
                $country->isoNumeric,
                $country->population,
                $country->square,
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'insert execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
    public function Edit(string $code, Country $country): void{
        try {
            // создать подключеник к БД
            $conn = $this->conn->openDbConnection();
             //WHERE
            $param = "isoAlpha3_f";
            $bind = "ssii";
            if(intval($code)){
                $param = "isoNumeric_f";
                $bind = $bind."i";
            }
            else {
                if(mb_strlen($code)===2) $param = "isoAlpha2_f";
                elseif (mb_strlen($code)===3) $param = "isoAlpha3_f";
                $bind = $bind."s";
            }
            // подготовить запрос INSERT
            $queryStr = 'UPDATE country_t 
                        SET short_name_f=?, full_name_f=?, population_f=?, square_f=?
                        WHERE '.$param.' = ?';
            // подготовить запрос
            $query = $conn->prepare(query: $queryStr);
            $query->bind_param(
                $bind, 
                $country->shortName,
                $country->fullName,
                $country->population,
                $country->square,
                $code,
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'update execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
    public function Delete(string $code): void{
         try {
            // создать подключеник к БД
            $conn = $this->conn->openDbConnection();
             //WHERE
            $param = "isoAlpha3_f";
            $bind = "s";
            if(intval($code)){
                $param = "isoNumeric_f";
                $bind = "i";
            }
            else {
                if(mb_strlen($code)===2) $param = "isoAlpha2_f";
                elseif (mb_strlen($code)===3) $param = "isoAlpha3_f";
            }
            // подготовить запрос INSERT
            $queryStr = 'DELETE FROM country_t WHERE '.$param.' = ?';
            // подготовить запрос
            $query = $conn->prepare(query: $queryStr);
            $query->bind_param($bind, $code);
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'delete execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
}
