<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Query
 * @package Panda\MikBill\Pbx\AssistantApi
 * Запросы к БД
 */
class Query
{
    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkStop(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_STOP, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkBlock(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_BLOCK, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkDelete(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_DELETE, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkFreeze(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_FREEZE, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkWork(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_WORK, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkDefect(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_DEFECT, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkActive(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_ACTIVE, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkClient(string $cId): ?array
    {
        return self::getResult(Sql::CHECK_CLIENT, $cId);
    }

    /**
     * @param string $statement Подготавливаемый запрос
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    private static function getResult(string $statement,
                                      string $cId): ?array
    {
        $sth = Statement::prepare($statement);

        $sth->bindParam(Holder::C_ID, $cId);

        Statement::execute($sth);

        return (($result = $sth->fetch(\PDO::FETCH_ASSOC)) !== false)
            ? $result
            : null;
    }
}
