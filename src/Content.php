<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Content
 * @package Panda\MikBill\Vpbx\AssistantApi
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
