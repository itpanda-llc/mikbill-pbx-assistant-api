<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI\Dictionary;

/**
 * Class Present
 * @package Panda\MikBill\VirtualPBXAPI\Dictionary
 * Приветствия (Общие) (Словарный запас)
 */
class Present extends Dictionary
{
    /**
     * Сообщения
     */
    public const SAMPLES = [
        'Приветствуем! На связи проект ' . Company::NAME . '!',
        'Здравствуйте! Это проект ' . Company::NAME . '!',
        'Вас приветствует и благодарит за интерес к услугам оператор связи - ' . Company::NAME . '!',
        'Компания ' . Company::NAME . ' рада вас слышать! Спасибо за интерес к нашим сервисам и услугам!',
        'Компания ' . Company::NAME . ' рада вас приветствовать! Благодарим за интерес к нашим услугам!',
        'Проект ' . Company::NAME . ' приветствует и благодарит вас за обращение!',
        'Добро пожаловать в компанию ' . Company::NAME . '! Спасибо за ваш звонок!',
        'Вас приветствует проект ' . Company::NAME . '! Спасибо за ваш звонок!',
        'Вас приветствует проект ' . Company::NAME . '! Благодарим за интерес к нашим услугам и желаем всегда быть на связи!',
        'Доброго времени суток! Оператор связи ' . Company::NAME . ' рад приветствовать вас!'
    ];
}
