<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru;

use Panda\MikBill\Vpbx\AssistantApi\Dictionary;

/**
 * Class Welcome
 * @package Panda\MikBill\Vpbx\AssistantApi\Dictionary\Ru
 * Приветствия (Персональные) (Словарный запас)
 */
class Welcome extends Dictionary\Param
{
    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Приветствуем вас,',
        'Рады вас слышать,',
        'Доброго времени суток,',
        'Здравствуйте,',
        'Добро пожаловать,',
        'Рады вас приветствовать,'
    ];
}
