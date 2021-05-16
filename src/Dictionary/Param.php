<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Param
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary
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
