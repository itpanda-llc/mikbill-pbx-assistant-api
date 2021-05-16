<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Field
 * @package Panda\MikBill\Vpbx\AssistantApi
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
