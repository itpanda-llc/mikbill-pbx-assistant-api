<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Delete
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
 * Сообщения об удалении (Словарный запас)
 */
class Delete extends Dictionary\Param
{
    /**
     * Интро
     */
    public const INTRO = [
        'Ваш аккаунт удален.',
        'Оказание услуг и предоставление сервисов невозможно в связ+и с удалением аккаунта.'
    ];

    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Для получения дополнительной информации обратитесь в службу сервиса.',
        'Для восстановления учетной записи обратитесь в службу сервиса.'
    ];
}
