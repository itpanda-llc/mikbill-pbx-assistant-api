<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Wait
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
 * Сообщения об ожидании (Словарный запас)
 */
class Wait extends Dictionary\Param
{
    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Оставайтесь на линии для диалога со специалистом. Разговор может быть записан.',
        'Для диалога со специалистом, оставайтесь на линии. Разговор может быть записан.',
        'Ожидание на линии позволит вам связаться со специалистом. Разговор может быть записан.',
        'Оставайтесь на линии для разговора со специалистом. Диалог может быть записан.',
        'Для разговора со специалистом, оставайтесь на линии. Диалог может быть записан.',
        'Ожидание на линии позволит вам связаться со специалистом. Диалог может быть записан.'
    ];
}
