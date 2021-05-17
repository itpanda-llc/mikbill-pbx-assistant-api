<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

/**
 * Class Content
 * @package Panda\MikBill\Pbx\AssistantApi
 * Заголовок ответа (Тип контента)
 */
class Content
{
    /**
     * application/json
     */
    public const APPLICATION_JSON = 'Content-Type: application/json';

    /**
     * audio/L16; 48000
     */
    public const AUDIO_L16 = 'Content-Type: audio/L16; rate=48000';

    /**
     * audio/ogg
     */
    public const AUDIO_OGG = 'Content-Type: audio/ogg';

    /**
     * audio/wav
     */
    public const AUDIO_WAV = 'Content-Type: audio/wav';

    /**
     * audio/mpeg
     */
    public const AUDIO_MPEG = 'Content-Type: audio/mpeg';
}
