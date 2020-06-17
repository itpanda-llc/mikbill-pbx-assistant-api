<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Dictionary\Dictionary;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Company;

/**
 * Class SMS
 * @package Panda\MikBill\VirtualPBXAPI
 * Параметры сообщения
 */
class SMS extends Dictionary
{
    /**
     * Сообщения
     */
    public const SAMPLES = [
        'приглашаем к диалогу в ваш личный кабинет.',
        'пообщаемся в вашем личном кабинете?'
    ];

    /**
     * Аутро
     */
    public const OUTRO = [
        'Ответить:',
        'Войти:',
        'Начать:'
    ];

    /**
     * Наименование оператора
     */
    public const COMPANY_NAME = Company::NAME;

    /**
     * URL-адрес кабинета
     */
    public const CABINET_URL = 'https://subdomain.domain.ru/';

    /**
     * Языковой параметр кабинета
     */
    public const CABINET_LANG = 'ru_RU';

    /**
     * Текст ошибки отправки
     */
    public const ERROR_TEXT = 'Не отправлено';
}
