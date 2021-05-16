<?php

/**
 * Файл из репозитория MikBill-VPBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-vpbx-assistant-api
 */

namespace Panda\MikBill\Vpbx\AssistantApi;

/**
 * Class Sql
 * @package Panda\MikBill\Vpbx\AssistantApi
 * SQL-запросы
 */
class Sql
{
    /**
     * Проверка остановки
     */
    public const CHECK_STOP = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 1
                AND
            `users`.`blocked` = 1
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка приостановления
     */
    public const CHECK_FREEZE = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 2
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка блокировки
     */
    public const CHECK_BLOCK = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 3
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка удаления
     */
    public const CHECK_DELETE = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 4
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка сообщения о проведении профилактических мероприятй
     */
    public const CHECK_WORK = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM 
            `users`
        LEFT JOIN
            `sms_logs`
                ON
                    `sms_logs`.`uid` = `users`.`uid`
                        AND
                    `sms_logs`.`sms_send_datetime` > DATE_SUB(
                        NOW(),
                        INTERVAL 1 DAY
                    )
                        AND
                    (
                        `sms_logs`.`staffid` != 0
                            AND
                        `sms_logs`.`staffid` IS NOT NULL
                    )
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 1
                AND
            `users`.`blocked` = 0
                AND
            `users`.`fio` != ''
                AND
            `sms_logs`.`uid` IS NOT NULL
        LIMIT
            1";

    /**
     * Проверка специфической активности PPP-сессий
     */
    public const CHECK_DEFECT = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`,
            CONCAT(
                SUBSTRING(
                    `lanes`.`lane`,
                    1,
                    (
                        LENGTH(
                            `lanes`.`lane`
                        )
                            -
                        LOCATE(
                            ' ',
                            REVERSE(
                                `lanes`.`lane`
                            )
                        )
                    )
                ),
                ', ',
                `lanes_houses`.`house`
            ) AS
                `" . Field::ADDRESS . "`,
            `acct`.`time` AS
                `" . Field::TIME . "`
        FROM
            `users`
        LEFT JOIN
            `lanes_houses`
                ON
                    `lanes_houses`.`houseid` = `users`.`houseid`
        LEFT JOIN
            `lanes`
                ON
                    `lanes`.`laneid` = `lanes_houses`.`laneid`
        LEFT JOIN
            `radacctbras`
                ON
                    `radacctbras`.`uid` = `users`.`uid`
        JOIN
            (
                SELECT
                    COUNT(
                        `radacct`.`uid`
                    ) AS
                        `count`,
                    GREATEST(
                        0,
                        FLOOR(
                            TIMESTAMPDIFF(
                                MINUTE,
                                NOW(),
                                `radacct`.`acctstoptime` + INTERVAL 60 MINUTE
                            ) / 10
                        ) * 10
                    ) AS
                        `time`
                FROM
                    `radacct`
                LEFT JOIN
                    `radacctbras`
                        ON
                            `radacctbras`.`uid` = `radacct`.`uid`
                WHERE
                    `radacct`.`acctstoptime`
                        >
                    (
                        SELECT
                            `radacct`.`acctstoptime`
                        FROM
                            `users`
                        LEFT JOIN
                            `radacctbras`
                                ON
                                    `radacctbras`.`uid` = `users`.`uid`
                        LEFT JOIN
                            `radacct`
                                ON
                                    `radacct`.`uid` = `users`.`uid`
                                        AND
                                    `radacct`.`acctstoptime` > DATE_SUB(
                                        NOW(),
                                        INTERVAL 1 DAY
                                    )
                        WHERE
                            " . Holder::C_ID . " IN (
                                `users`.`phone`,
                                `users`.`mob_tel`,
                                `users`.`sms_tel`
                            )
                                AND
                            `users`.`blocked` = 0
                                AND
                            `radacctbras`.`uid` IS NULL
                                AND
                            `radacct`.`uid` IS NOT NULL
                        ORDER BY
                            `radacct`.`acctstoptime`
                        DESC
                        LIMIT
                            1
                    ) - INTERVAL 15 SECOND
                        AND
                    `radacct`.`acctstoptime`
                        <
                    (
                        SELECT
                            `radacct`.`acctstoptime`
                        FROM
                            `users`
                        LEFT JOIN
                            `radacctbras`
                                ON
                                    `radacctbras`.`uid` = `users`.`uid`
                        LEFT JOIN
                            `radacct`
                                ON
                                    `radacct`.`uid` = `users`.`uid`
                                        AND
                                    `radacct`.`acctstoptime` > DATE_SUB(
                                        NOW(),
                                        INTERVAL 1 DAY
                                    )
                        WHERE
                            " . Holder::C_ID . " IN (
                                `users`.`phone`,
                                `users`.`mob_tel`,
                                `users`.`sms_tel`
                            )
                                AND
                            `users`.`blocked` = 0
                                AND
                            `radacctbras`.`uid` IS NULL
                                AND
                            `radacct`.`uid` IS NOT NULL
                        ORDER BY
                            `radacct`.`acctstoptime`
                        DESC
                        LIMIT
                            1
                    ) + INTERVAL 15 SECOND
                        AND
                    `radacctbras`.`uid` IS NULL
            ) AS
                `acct`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 1
                AND
            `users`.`blocked` = 0
                AND
            `users`.`fio` != ''
                AND
            `radacctbras`.`uid` IS NULL
                AND
            `acct`.`count` > 5
                AND
            `acct`.`time` IS NOT NULL
        LIMIT
            1";

    /**
     * Проверка активности
     */
    public const CHECK_ACTIVE = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`state` = 1
                AND
            `users`.`blocked` = 0
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка клиента
     */
    public const CHECK_CLIENT = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ',
                    `users`.`fio`
                ) + 1
            ) AS
                `" . Field::NAME . "`
        FROM
            `users`
        WHERE
            " . Holder::C_ID . " IN (
                `users`.`phone`,
                `users`.`mob_tel`,
                `users`.`sms_tel`
            )
                AND
            `users`.`fio` != ''
        LIMIT
            1";
}
