<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

/**
 * Class Statement
 * @package Panda\MikBill\VirtualPBXAPI
 * Операции с запросами к БД
 */
class Statement
{
    /**
     * @param string $statement Подготавливаемый запрос
     * @return \PDOStatement Объект для работы с запросом
     */
    public static function prepare(string $statement): \PDOStatement
    {
        try {
            return DB::connect()->prepare($statement);
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * @param \PDOStatement $sth Объект для работы с запросом
     */
    public static function execute(\PDOStatement $sth): void
    {
        try {
            $sth->execute();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * @param string $statement Запрос
     * @return \PDOStatement Объект для работы с запросом
     */
    public static function query(string $statement): \PDOStatement
    {
        try {
            return DB::connect()->query($statement);
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * @param string $statement Запрос
     * @return int Количество строк
     */
    public static function exec(string $statement): int
    {
        try {
            return DB::connect()->exec($statement);
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }
}
