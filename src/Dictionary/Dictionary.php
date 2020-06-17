<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Dictionary
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Словарь
 */
class Dictionary
{
    /**
     * @return string Случайное значение (Интро)
     */
    public static function getIntro(): string
    {
        return static::INTRO[array_rand(static::INTRO)];
    }

    /**
     * @return string Случайное значение (Сообщения)
     */
    public static function getSample(): string
    {
        return static::SAMPLES[array_rand(static::SAMPLES)];
    }

    /**
     * @return string Случайное значение (Аутро)
     */
    public static function getOutro(): string
    {
        return static::OUTRO[array_rand(static::OUTRO)];
    }
}
