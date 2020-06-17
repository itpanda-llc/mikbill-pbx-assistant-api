<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Content
 * @package Panda\MikBill\VirtualPBXAPI
 * Заголовок ответа (Тип контента)
 */
class Content
{
    /**
     * application/json
     */
    public const JSON_TYPE = 'Content-Type: application/json';

    /**
     * audio/L16; 48000
     */
    public const L16_TYPE = 'Content-Type: audio/L16; rate=48000';

    /**
     * audio/ogg
     */
    public const OGG_TYPE = 'Content-Type: audio/ogg';

    /**
     * audio/wav
     */
    public const WAV_TYPE = 'Content-Type: audio/wav';

    /**
     * audio/mpeg
     */
    public const MPEG_TYPE = 'Content-Type: audio/mpeg';
}
