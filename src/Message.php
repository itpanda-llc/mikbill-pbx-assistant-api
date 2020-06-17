<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Message
 * @package Panda\MikBill\VirtualPBXAPI
 * Сообщения ответов (Значения констант переведены на английский язык для коррекного вида ответов в JSON-формате)
 */
class Message
{
    /**
     * Код: 0
     * Тикет успешно создан или уже существует
     */
    public const TICKET_OK = 'Ticket created successfully or already exists';

    /**
     * Код: 1
     * Неправильное значение параметра "Секрет"
     */
    public const SECRET_ERROR = 'Incorrect secret key option';

    /**
     * Код: 1
     * Неправильное значение параметра "Тип запроса"
     */
    public const TYPE_ERROR = 'Incorrect request type option';

    /**
     * Код: 1
     * Неправильное значение параметра "Формат аудио"
     */
    public const FORMAT_ERROR = 'Incorrect audio format option';

    /**
     * Код: 1
     * Неправильное значение параметра "Язык"
     */
    public const LANG_ERROR = 'Incorrect language option';

    /**
     * Код: 1
     * Неправильное значение параметра "Голос"
     */
    public const VOICE_ERROR = 'Incorrect voice option';

    /**
     * Код: 1
     * Неправильное значение параметра "Номер телефона"
     */
    public const CID_ERROR = 'Incorrect phone number option';

    /**
     * Код: 10
     * Создание категории тикета не выполнено
     */
    public const ADD_TICKET_CATEGORY_ERROR = 'Ticket category creation failed';

    /**
     * Код: 10
     * Создание тикета не выполнено
     */
    public const ADD_TICKET_ERROR = 'Ticket creation failed';

    /**
     * Код: 10
     * Создание примечания для тикета не выполнено
     */
    public const ADD_TICKET_NOTE_ERROR = 'Ticket note creation failed';

    /**
     * Код: 10
     * Создание сообщения для тикета не выполнено
     */
    public const ADD_TICKET_MESSAGE_ERROR = 'Ticket message creation failed';

    /**
     * Код: 10
     * Запись СМС-сообщения не выполнена
     */
    public const ADD_SMS_MESSAGE_ERROR = 'SMS message logging failed';

    /**
     * Код: 10
     * Создание временного файла не выполнено
     */
    public const GET_FILE_ERROR = 'Temporary file creation failed';

    /**
     * Код: 10
     * Неправильный статус выполнения системной команды
     */
    public const COMMAND_STATUS_ERROR = 'Incorrect system command execution status';

    /**
     * Код: 10
     * Удаление файла не выполнено
     */
    public const UNLINK_FILE_ERROR = 'File deletion failed';

    /**
     * Код: 10
     * Чтение или запись контента не выполнены
     */
    public const CONTENT_ERROR = 'Reading or writing content failed';
}
