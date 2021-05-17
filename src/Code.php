<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Code
 * @package Panda\MikBill\Pbx\AssistantApi
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
