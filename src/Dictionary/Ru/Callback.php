<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Callback
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
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
