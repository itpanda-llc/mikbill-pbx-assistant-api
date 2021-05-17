<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Config
 * @package Panda\MikBill\Pbx\AssistantApi
 * Получение конфигурации
 */
class Config
{
    /**
     * @var \SimpleXMLElement Объект конфигурационного файла
     */
    private static $sxe;

    /**
     * @return \SimpleXMLElement Объект конфигурационного файла
     */
    public static function get(): \SimpleXMLElement
    {
        if (!isset(self::$sxe))
            try {
                self::$sxe = new \SimpleXMLElement(CONFIG,
                    LIBXML_ERR_NONE,
                    true);
            } catch (\Exception $e) {
                throw new Exception\DebugException($e->getMessage());
            }

        return self::$sxe;
    }
}
