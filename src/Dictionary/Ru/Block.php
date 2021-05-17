<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

namespace Panda\MikBill\Pbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Pbx\AssistantApi\Dictionary;

/**
 * Class Block
 * @package Panda\MikBill\Pbx\AssistantApi\Dictionary\Ru
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
