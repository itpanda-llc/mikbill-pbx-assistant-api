<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class Cloud
 * @package Panda\MikBill\VirtualPBXAPI
 * Параметры сервиса "Яндекс.Облако"
 */
class Cloud
{
    /**
     * ID каталога
     * @link https://cloud.yandex.ru/docs/speechkit/tts/request
     */
    public const FOLDER_ID = 'b7g09h7opmmjgg8e1j4d';

    /**
     * OAuth-токен
     * @link https://cloud.yandex.ru/docs/iam/operations/iam-token/create
     */
    public const OAUTH_TOKEN = 'AgAALIOSeN6XAATuwduwAAZFyPOYsEW1gGBCI3s';
}
