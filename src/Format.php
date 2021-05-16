<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

use Panda\Yandex\SpeechKitSdk;

/**
 * Class Format
 * @package Panda\MikBill\Vpbx\AssistantApi
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
