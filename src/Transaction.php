<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

/**
 * Class Transaction
 * @package Panda\MikBill\Chelinvest\GorodAPI
 * Операции с транзакциями в БД
 */
class Transaction
{
    /**
     * Инициализация
     */
    public static function begin(): void
    {
        try {
            DB::connect()->beginTransaction();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * Фиксация
     */
    public static function commit(): void
    {
        try {
            DB::connect()->commit();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }

    /**
     * Откат
     */
    public static function rollBack(): void
    {
        try {
            DB::connect()->rollBack();
        } catch (\PDOException $e) {
            throw new DebugException($e->getMessage());
        }
    }
}
