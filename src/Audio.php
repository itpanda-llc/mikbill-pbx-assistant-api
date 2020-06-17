<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

/**
 * Class Audio
 * @package Panda\MikBill\VirtualPBXAPI
 * Операции с аудио
 */
class Audio
{
    /**
     * @param string $content Исходный контент
     * @return string Запрошенный контент
     */
    public static function getWav(string $content): string
    {
        $commandf = "sox -r 48000 -b 16 -e signed-integer"
            . " -c 1 -t raw %s -t wav %s";

        return self::convert($commandf, $content);
    }

    /**
     * @param string $content Исходный контент
     * @return string Запрошенный контент
     */
    public static function getMPEG(string $content): string
    {
        $commandf = "lame %s %s";

        return self::convert($commandf, $content);
    }

    /**
     * @param string $commandf Формат системной команды
     * @param string $content Исходный контент
     * @return string Запрошенный контент
     */
    private static function convert(string $commandf,
                                    string $content): string
    {
        $command = sprintf($commandf,
            $inFile = System::file(),
            $outFile = System::file());

        try {
            if (!file_put_contents($inFile, $content))
                throw new DebugException(Message::CONTENT_ERROR);

            System::exec($command);

            if (!$content = file_get_contents($outFile))
                throw new DebugException(Message::CONTENT_ERROR);
        } catch (DebugException $e) {
            throw new DebugException($e->getMessage());
        } finally {
            System::unlink($inFile, $outFile);
        }

        return $content;
    }
}
