<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Response
 * @package Panda\MikBill\VirtualPBXAPI
 * Формирование ответа
 */
class Response
{
    /**
     * @param int $code Код
     * @param string $message Сообщение
     * @return string JSON-контент
     */
    public static function getError(int $code,
                                    string $message): string
    {
        return json_encode([Field::CODE => $code,
            Field::MESSAGE => $message]);
    }

    /**
     * @param string $result Ответ
     * @return string JSON-контент
     */
    public static function getResult(string $result): string
    {
        return json_encode([Field::CODE => Code::DEFAULT,
            Field::RESULT => $result]);
    }
}
