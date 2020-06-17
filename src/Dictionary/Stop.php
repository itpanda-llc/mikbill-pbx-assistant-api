<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Stop
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Сообщения о приостановлении (Словарный запас)
 */
class Stop extends Dictionary
{
    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Для вашей учетной записи доступ к услугам ограничен.',
        'Для вашей учетной записи приостановлено оказание услуг и предоставление сервисов.',
        'Мы приостановили оказание услуг и предоставление сервисов для вашей учетной записи.',
        'Оказание услуг и предоставление сервисов для вашей учетной записи приостановлено.'
    ];

    /**
     * Аутро
     */
    public const OUTRO = [
        'Пополните баланс любым удобным способом, во избежание блокировки лицевого счета.',
        'Во избежание блокировки лицевого счета, пополните баланс любым удобным способом.'
    ];
}
