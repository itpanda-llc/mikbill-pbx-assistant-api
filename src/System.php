<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

/**
 * Class System
 * @package Panda\MikBill\VirtualPBXAPI
 * Системные операции
 */
class System
{
    /**
     * @return string Путь к файлу
     */
    public static function file(): string
    {
        if (!$file = tempnam(sys_get_temp_dir(), 'speech'))
            throw new DebugException(Message::GET_FILE_ERROR);

        return $file;
    }

    /**
     * @param string $command Системная команда
     */
    public static function exec(string $command): void
    {
        exec($command, $output, $status);

        if ($status !== 0)
            throw new DebugException(Message::COMMAND_STATUS_ERROR);
    }

    /**
     * @param string ...$links Пути к файлам
     */
    public static function unlink(string ...$links): void
    {
        foreach ($links as $link)
            if (!unlink($link))
                throw new DebugException(Message::UNLINK_FILE_ERROR);
    }
}
