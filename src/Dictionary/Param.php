<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi\Dictionary;

/**
 * Class Param
 * @package Panda\MikBill\Pbx\AssistantApi\Dictionary
 * Словарь
 */
class Param
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
