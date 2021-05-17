<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Message
 * @package Panda\MikBill\Pbx\AssistantApi
 * Сообщения ответов
 */
class Message
{
    /**
     * Неправильное значение параметра "Секрет"
     * Код: 1
     */
    public const SECRET_ERROR = 'Incorrect secret key option';

    /**
     * Неправильное значение параметра "Тип запроса"
     * Код: 1
     */
    public const TYPE_ERROR = 'Incorrect request type option';

    /**
     * Неправильное значение параметра "Формат аудио"
     * Код: 1
     */
    public const FORMAT_ERROR = 'Incorrect audio format option';

    /**
     * Неправильное значение параметра "Язык"
     * Код: 1
     */
    public const LANG_ERROR = 'Incorrect language option';

    /**
     * Неправильное значение параметра "Голос"
     * Код: 1
     */
    public const VOICE_ERROR = 'Incorrect voice option';

    /**
     * Неправильное значение параметра "Номер телефона"
     * Код: 1
     */
    public const C_ID_ERROR = 'Incorrect phone number option';
}
