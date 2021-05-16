<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Cloud
 * @package Panda\MikBill\Vpbx\AssistantApi
 * Параметры сервиса "Яндекс.Облако"
 */
class Cloud
{
    /**
     * API-ключ
     * @link @link https://cloud.yandex.ru/docs/iam/concepts/authorization/api-key
     */
    public const API_KEY = '***';

    /**
     * OAuth-токен
     * @link https://cloud.yandex.ru/docs/iam/operations/iam-token/create
     */
    public const OAUTH_TOKEN = '***';

    /**
     * ID каталога
     * @link https://cloud.yandex.ru/docs/speechkit/tts/request
     */
    public const FOLDER_ID = '***';
}
