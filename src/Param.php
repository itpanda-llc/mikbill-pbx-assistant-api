<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Param
 * @package Panda\MikBill\Pbx\AssistantApi
 * Наименования параметров запроса
 */
class Param
{
    /**
     * Секрет
     */
    public const SECRET = 'secret';

    /**
     * Тип
     */
    public const TYPE = 'type';

    /**
     * Формат ответа
     */
    public const FORMAT = 'format';

    /**
     * Язык
     */
    public const LANG = 'lang';

    /**
     * Голос
     */
    public const VOICE = 'voice';

    /**
     * Номер телефона
     */
    public const C_ID = 'c_id';
}
