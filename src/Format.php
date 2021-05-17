<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi;

use Panda\Yandex\SpeechKitSdk;

/**
 * Class Format
 * @package Panda\MikBill\Pbx\AssistantApi
 * Формат ответа
 */
class Format extends SpeechKitSdk\Format
{
    /**
     * Текст
     */
    public const TEXT = 'text';

    /**
     * WAV (аудио)
     */
    public const WAV = 'wav';

    /**
     * MPEG (аудио)
     */
    public const MPEG = 'mpeg';
}
