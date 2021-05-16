<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Type
 * @package Panda\MikBill\Vpbx\AssistantApi
 * Тип запроса/сценария
 */
class Type
{
    /**
     * Обычный (Приветствие + информация + ожидание)
     */
    public const REGULAR = 'regular';

    /**
     * Представление
     */
    public const PRESENT = 'present';

    /**
     * Промо
     */
    public const PROMO = 'promo';

    /**
     * Приветствие (Представление / Имя + Промо)
     */
    public const GREETING = 'greeting';

    /**
     * Информация (Остановка / Блокировка / Удаление / Заморозка / Профилактика + Извинения / Дефект + Извинения / Промо / Представление)
     */
    public const INFO = 'info';

    /**
     * Ожидание
     */
    public const WAITING = 'waiting';

    /**
     * Обратный вызов
     */
    public const CALLBACK = 'callback';

    /**
     * Блокировка
     */
    public const BLOCK = 'block';

    /**
     * Удаление
     */
    public const DELETE = 'delete';

    /**
     * Заморозка
     */
    public const FREEZE = 'freeze';

    /**
     * Извинение
     */
    public const APOLOGY = 'apology';

    /**
     * Остановка
     */
    public const STOP = 'stop';

    /**
     * Профилактика
     */
    public const WORK = 'work';
}
