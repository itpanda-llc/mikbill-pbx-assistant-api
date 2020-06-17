<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Type
 * @package Panda\MikBill\VirtualPBXAPI
 * Тип запроса
 */
class Type
{
    /**
     * Приветствие
     */
    public const WELCOME = 'welcome';

    /**
     * Сообщение об обратном вызове
     */
    public const CALLBACK = 'callback';

    /**
     * Создание тикета
     */
    public const TICKET = 'ticket';
}
