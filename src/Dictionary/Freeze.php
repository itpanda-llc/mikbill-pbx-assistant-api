<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Freeze
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Сообщения о заморозке (Словарный запас)
 */
class Freeze extends Dictionary
{
    /**
     * Интро
     */
    public const INTRO = [
        'Вы приостановили оказание услуг и предоставление сервисов.',
        'Оказание услуг и предоставление сервисов было добровольно приостановлено.'
    ];

    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Для получения дополнительной информации обратитесь в службу сервиса.',
        'Для отмены настоящего ограничения, ранее заказанного периода, обратитесь в службу сервиса.'
    ];
}
