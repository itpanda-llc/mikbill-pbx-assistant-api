<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Pbx\AssistantApi\Dictionary;

/**
 * Class Callback
 * @package Panda\MikBill\Pbx\AssistantApi\Dictionary\Ru
 * Сообщения об обратном вызове (Словарный запас)
 */
class Callback extends Dictionary\Param
{
    /**
     * Интро
     */
    public const INTRO = [
        'К сожалению,'
    ];

    /**
     * Сообщения
     */
    public const SAMPLES = [
        'сейчас, нет возможности ответить на ваше обращение.',
        'в настоящее время, мы не можем ответить на ваше обращение.'
    ];

    /**
     * Аутро
     */
    public const OUTRO = [
        'Приглашаем к диалогу в ваш личный кабинет.',
        'Ожидайте нашего вызова позднее.'
    ];
}
