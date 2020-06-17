<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Query
 * @package Panda\MikBill\VirtualPBXAPI
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
        return self::getResult(SQL::CHECK_STOP, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkBlock(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_BLOCK, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkDelete(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_DELETE, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkFreeze(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_FREEZE, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkWork(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_WORK, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkDefect(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_DEFECT, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkActive(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_ACTIVE, $cId);
    }

    /**
     * @return bool Результат проверки наличия категории тикета
     */
    public static function checkCategory(): bool
    {
        $sth = Statement::query(SQL::CHECK_CATEGORY);

        return ($sth->rowCount() !== 0) ? true : false;
    }

    /**
     * @return bool Результат добавления категории тикета
     */
    public static function addCategory(): bool
    {
        return (Statement::exec(SQL::ADD_CATEGORY) !== 0)
            ? true
            : false;
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkTicket(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_TICKET, $cId);
    }

    /**
     * @param string $cId Номер телефона
     * @return bool Результат добавления тикета
     */
    public static function addTicket(string $cId): bool
    {
        $sth = Statement::prepare(SQL::ADD_TICKET);

        $sth->bindParam(Holder::C_ID, $cId);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0) ? true : false;
    }

    /**
     * @param string $ticketId ID тикета
     * @param string $ticketNote Примечание
     * @return bool Результат добавления примечания
     */
    public static function addNote(string $ticketId,
                                   string $ticketNote): bool
    {
        $sth = Statement::prepare(SQL::ADD_NOTE);

        $sth->bindParam(Holder::TICKET_ID, $ticketId);
        $sth->bindParam(Holder::TICKET_NOTE, $ticketNote);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0) ? true : false;
    }

    /**
     * @param string $cId Номер телефона
     * @return array|null Результат запроса
     */
    public static function checkClient(string $cId): ?array
    {
        return self::getResult(SQL::CHECK_CLIENT, $cId);
    }

    /**
     * @param string $ticketId ID тикета
     * @param string $ticketMessage Сообщение
     * @return bool Результат добавления сообщения
     */
    public static function addMessage(string $ticketId,
                                      string $ticketMessage): bool
    {
        $sth = Statement::prepare(SQL::ADD_MESSAGE);

        $sth->bindParam(Holder::TICKET_ID, $ticketId);
        $sth->bindParam(Holder::TICKET_MESSAGE, $ticketMessage);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0) ? true : false;
    }

    /**
     * @param string $uId ID пользователя
     * @param string $phone Номер телефона
     * @param string $text Текст сообщения
     * @param string $errorText Текст ошибки
     * @return bool Результат добавления сообщения
     */
    public static function logMessage(string $uId,
                                      string $phone,
                                      string $text,
                                      string $errorText): bool
    {
        $sth = Statement::prepare(SQL::LOG_MESSAGE);

        $sth->bindParam(Holder::U_ID, $uId);
        $sth->bindParam(Holder::C_ID, $phone);
        $sth->bindParam(Holder::SMS_TEXT, $text);
        $sth->bindParam(Holder::SMS_ERROR_TEXT, $errorText);

        Statement::execute($sth);

        return ($sth->rowCount() !== 0) ? true : false;
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
