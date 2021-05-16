<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Freeze
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
 * Сообщения о заморозке (Словарный запас)
 */
class Freeze extends Dictionary\Param
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
