<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Param
 * @package Panda\MikBill\VirtualPBXAPI
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
    public const CID = 'cid';
}
