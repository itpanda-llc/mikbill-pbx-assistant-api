<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Dictionary\Dictionary;

/**
 * Class Ticket
 * @package Panda\MikBill\VirtualPBXAPI
 * Параметры тикета
 */
class Ticket extends Dictionary
{
    /**
     * Интро
     */
    public const INTRO = [
        'Приветствуем,',
        'Здравствуйте,',
        'Добро пожаловать,'
    ];

    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Спасибо, что пользуетесь нашими услугами! Какой у вас вопрос?',
        'От вас есть пропущенный вызов. Пообщаемся здесь? Какой у вас вопрос?'
    ];

    /**
     * Наименование категории
     */
    public const CATEGORY_NAME = 'Виртуальная АТС';

    /**
     * Описание категории
     */
    public const CATEGORY_DESCRIPTION = 'Автоматическая заявка (IP-Телефония)';

    /**
     * Примечание
     */
    public const NOTE = 'Создан автоматически';

    /**
     * ID типа приоритета
     */
    public const PRIORITY_TYPE_ID = 2;
}
