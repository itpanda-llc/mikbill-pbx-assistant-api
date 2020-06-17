<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Block
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Сообщения о блокировке (Словарный запас)
 */
class Block extends Dictionary
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
