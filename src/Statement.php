<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Statement
 * @package Panda\MikBill\Pbx\AssistantApi
 * Операции с запросами к БД
 */
class Statement
{
    /**
     * Подготовление запроса не удалось
     */
    private const PREPARE_EXCEPTION_MESSAGE = 'Request preparation failed';

    /**
     * Выполнение запроса не удалось
     */
    private const LAUNCH_EXCEPTION_MESSAGE = 'Query launch failed';

    /**
     * @param string $statement Подготавливаемый запрос
     * @return \PDOStatement Объект для работы с запросом
     */
    public static function prepare(string $statement): \PDOStatement
    {
        try {
            if (($sth = Db::connect()->prepare($statement)) === false)
                throw new Exception\SystemException(self::PREPARE_EXCEPTION_MESSAGE);

            return $sth;
        } catch (\PDOException $e) {
            throw new Exception\DebugException($e->getMessage());
        }
    }

    /**
     * @param \PDOStatement $sth Объект для работы с запросом
     */
    public static function execute(\PDOStatement $sth): void
    {
        try {
            if (($sth = $sth->execute()) === false)
                throw new Exception\SystemException(self::LAUNCH_EXCEPTION_MESSAGE);
        } catch (\PDOException $e) {
            throw new Exception\DebugException($e->getMessage());
        }
    }
}
