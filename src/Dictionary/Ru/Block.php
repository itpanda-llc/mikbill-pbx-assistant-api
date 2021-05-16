<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Block
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
 * Сообщения о блокировке (Словарный запас)
 */
class Block extends Dictionary\Param
{
    /**
     * Интро
     */
    public const INTRO = [
        'Ваша учетная запись заблокирована.',
        'Оказание услуг и предоставление сервисов остановлено в связ+и с блокировкой учетной записи.'
    ];

    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Для получения дополнительной информации обратитесь в службу сервиса.',
        'Для восстановления аккаунта обратитесь в службу сервиса.'
    ];
}
