<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Format
 * @package Panda\MikBill\VirtualPBXAPI
 * Формат ответа
 */
class Format
{
    /**
     * Текст
     */
    public const TEXT = 'text';

    /**
     * LPCM (аудио)
     */
    public const LPCM = 'lpcm';

    /**
     * OGGOPUS (аудио)
     */
    public const OGGOPUS = 'oggopus';

    /**
     * WAV (аудио)
     */
    public const WAV = 'wav';

    /**
     * MPEG (аудио)
     */
    public const MPEG = 'mpeg';
}
