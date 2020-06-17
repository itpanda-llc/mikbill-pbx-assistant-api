<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Delete
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Сообщения об удалении (Словарный запас)
 */
class Delete extends Dictionary
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
