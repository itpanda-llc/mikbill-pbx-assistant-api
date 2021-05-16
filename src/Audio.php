<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Audio
 * @package Panda\MikBill\Vpbx\AssistantApi
 * Операции с аудио
 */
class Audio
{
    /**
     * Чтение или запись контента не выполнены
     */
    public const CONTENT_ERROR_MESSAGE = 'Reading or writing content failed';

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
    public static function getMpeg(string $content): string
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
                throw new Exception\SystemException(self::CONTENT_ERROR_MESSAGE);

            System::exec($command);

            if (!$content = file_get_contents($outFile))
                throw new Exception\SystemException(self::CONTENT_ERROR_MESSAGE);
        } catch (Exception\SystemException $e) {
            throw new Exception\SystemException($e->getMessage());
        } finally {
            System::unlink($inFile, $outFile);
        }

        return $content;
    }
}
