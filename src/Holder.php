<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Holder
 * @package Panda\MikBill\VirtualPBXAPI
 * Наименования параметров (SQL-запросы)
 */
class Holder
{
    /**
     * Номер телефона пользователя
     */
    public const C_ID = ':cId';

    /**
     * ID тикета
     */
    public const TICKET_ID = ':ticketId';

    /**
     * Примечание к тикету
     */
    public const TICKET_NOTE = ':ticketNote';

    /**
     * Сообщение тикета
     */
    public const TICKET_MESSAGE = ':ticketMessage';

    /**
     * ID пользователя
     */
    public const U_ID = ':uId';

    /**
     * Текст СМС-сообщения
     */
    public const SMS_TEXT = ':smsText';

    /**
     * Текст ошибки СМС-сообщения
     */
    public const SMS_ERROR_TEXT = ':smsErrorText';
}
