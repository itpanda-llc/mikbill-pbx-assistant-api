<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Index
 * @package Panda\MikBill\VirtualPBXAPI
 * Наименования полей (SQL-запросы)
 */
class Index
{
    /**
     * Имя пользователя
     */
    public const NAME = 'name';

    /**
     * Адрес неисправности
     */
    public const ADDRESS = 'address';

    /**
     * Срок устранения неисправности
     */
    public const TIME = 'time';

    /**
     * ID тикета
     */
    public const TICKET_ID = 'ticketId';

    /**
     * ID пользователя
     */
    public const U_ID = 'uId';

    /**
     * Логин пользователя
     */
    public const LOGIN = 'login';

    /**
     * Пароль пользователя
     */
    public const PASSWORD = 'password';
}
