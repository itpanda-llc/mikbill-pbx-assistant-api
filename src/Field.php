<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Field
 * @package Panda\MikBill\Pbx\AssistantApi
 * Наименования полей (SQL-запросы)
 */
class Field
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
}
