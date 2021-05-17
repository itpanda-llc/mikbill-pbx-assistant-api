<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Response
 * @package Panda\MikBill\Pbx\AssistantApi
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
        return json_encode([Key::CODE => $code,
            Key::MESSAGE => $message]);
    }

    /**
     * @param string $result Ответ
     * @return string JSON-контент
     */
    public static function getResult(string $result): string
    {
        return json_encode([Key::CODE => Code::DEFAULT,
            Key::RESULT => $result]);
    }
}
