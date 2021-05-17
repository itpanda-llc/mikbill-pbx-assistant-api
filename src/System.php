<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class System
 * @package Panda\MikBill\Pbx\AssistantApi
 * Системные операции
 */
class System
{
    /**
     * Создание временного файла не выполнено
     */
    public const GET_FILE_ERROR_MESSAGE = 'Temporary file creation failed';

    /**
     * Неправильный статус выполнения системной команды
     */
    public const COMMAND_STATUS_ERROR_MESSAGE = 'Incorrect system command execution status';

    /**
     * Удаление файла не выполнено
     */
    public const UNLINK_FILE_ERROR_MESSAGE = 'File deletion failed';

    /**
     * @return string Путь к файлу
     */
    public static function file(): string
    {
        if (!$file = tempnam(sys_get_temp_dir(), 'speech'))
            throw new Exception\SystemException(self::GET_FILE_ERROR_MESSAGE);

        return $file;
    }

    /**
     * @param string $command Системная команда
     */
    public static function exec(string $command): void
    {
        exec($command, $output, $status);

        if ($status !== 0)
            throw new Exception\SystemException(self::COMMAND_STATUS_ERROR_MESSAGE);
    }

    /**
     * @param string ...$links Пути к файлам
     */
    public static function unlink(string ...$links): void
    {
        foreach ($links as $v)
            if (!unlink($v))
                throw new Exception\SystemException(self::UNLINK_FILE_ERROR_MESSAGE);
    }
}
