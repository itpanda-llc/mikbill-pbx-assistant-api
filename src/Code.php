<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Code
 * @package Panda\MikBill\VirtualPBXAPI
 * Код ответа
 */
class Code
{
    /**
     * Без ошибок (Нормальный ответ)
     */
    public const DEFAULT = 0;

    /**
     * Информация об ошибке
     */
    public const ERROR = 1;

    /**
     * Информация для отладки
     */
    public const DEBUG = 10;
}
