<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Callback
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Сообщения об обратном вызове (Словарный запас)
 */
class Callback extends Dictionary
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
