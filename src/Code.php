<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Code
 * @package Panda\MikBill\Vpbx\AssistantApi
 * Код ответа
 */
class Code
{
    /**
     * Без ошибок (Нормальный ответ)
     */
    public const DEFAULT = 0;

    /**
     * Ошибка в запросе
     */
    public const REQUEST_ERROR = 1;

    /**
     * Системная ошибка
     */
    public const SYSTEM_ERROR = 2;

    /**
     * Ошибка отладки
     */
    public const DEBUG_ERROR = 10;
}
