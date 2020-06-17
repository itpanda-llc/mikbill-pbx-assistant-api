<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Text
 * @package Panda\MikBill\VirtualPBXAPI
 * Формирование текста
 */
class Text
{
    /**
     * @param string ...$strings Строки
     * @return string Объединенная строка
     */
    public static function get(string ...$strings): string
    {
        return implode(' ', $strings);
    }
}
