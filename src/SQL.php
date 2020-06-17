<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

/**
 * Class SQL
 * @package Panda\MikBill\VirtualPBXAPI
 * SQL-запросы
 */
class SQL
{
    /**
     * Проверка остановки
     */
    public const CHECK_STOP = "
        SELECT
            SUBSTRING(
                `users`.`fio`,
                LOCATE(
                    ' ', `users`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            `users`
        WHERE
            (
                `users`.`phone` = " . Holder::C_ID . "
                    OR
                `users`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `users`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `blocked` = 1
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
                `usersblok`.`fio`,
                LOCATE(
                    ' ', `usersblok`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            `usersblok`
        WHERE
            (
                `usersblok`.`phone` = " . Holder::C_ID . "
                    OR
                `usersblok`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `usersblok`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `usersblok`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка удаления
     */
    public const CHECK_DELETE = "
        SELECT
            SUBSTRING(
                `usersdel`.`fio`,
                LOCATE(
                    ' ', `usersdel`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            `usersdel`
        WHERE
            (
                `usersdel`.`phone` = " . Holder::C_ID . "
                    OR
                `usersdel`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `usersdel`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `usersdel`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка приостановления
     */
    public const CHECK_FREEZE = "
        SELECT
            SUBSTRING(
                `usersfreeze`.`fio`,
                LOCATE(
                    ' ', `usersfreeze`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            `usersfreeze`
        WHERE
            (
                `usersfreeze`.`phone` = " . Holder::C_ID . "
                    OR
                `usersfreeze`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `usersfreeze`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `usersfreeze`.`fio` != ''
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
                    ' ', `users`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
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
                    `sms_logs`.`sms_text` LIKE '%рофилак%'
        WHERE
            (
                `users`.`phone` = " . Holder::C_ID . "
                    OR
                `users`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `users`.`sms_tel` = " . Holder::C_ID . "
            )
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
                    ' ', `users`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`,
            CONCAT(
                SUBSTRING(
                    `lanes`.`lane`, 1,
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
                ), ', ', `lanes_houses`.`house`
            ) AS
                `" . Index::ADDRESS . "`,
            `acct`.`time` AS
                `" . Index::TIME . "`
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
                    (
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
                            (
                                `users`.`phone` = " . Holder::C_ID . "
                                    OR
                                `users`.`mob_tel` = " . Holder::C_ID . "
                                    OR
                                `users`.`sms_tel` = " . Holder::C_ID . "
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
                            (
                                `users`.`phone` = " . Holder::C_ID . "
                                    OR
                                `users`.`mob_tel` = " . Holder::C_ID . "
                                    OR
                                `users`.`sms_tel` = " . Holder::C_ID . "
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
            (
                `users`.`phone` = " . Holder::C_ID . "
                    OR
                `users`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `users`.`sms_tel` = " . Holder::C_ID . "
            )
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
                    ' ', `users`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            `users`
        WHERE
            (
                `users`.`phone` = " . Holder::C_ID . "
                    OR
                `users`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `users`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `users`.`blocked` = 0
                AND
            `users`.`fio` != ''
        LIMIT
            1";

    /**
     * Проверка категории тикета
     */
    public const CHECK_CATEGORY = "
        SELECT
            `tickets_categories_list`.`categoryid`
        FROM
            `tickets_categories_list`
        WHERE
            `tickets_categories_list`.`categoryname`
                =
            '" . Ticket::CATEGORY_NAME . "'
        LIMIT
            1";

    /**
     * Добавление категории тикета
     */
    public const ADD_CATEGORY = "
        INSERT INTO
            `tickets_categories_list` (
                `categoryname`,
                `description`
            )
        VALUES (
            '" . Ticket::CATEGORY_NAME . "',
            '" . Ticket::CATEGORY_DESCRIPTION . "'
        )";

    /**
     * Проверка тикета
     */
    public const CHECK_TICKET = "
        SELECT
            `tickets_tickets`.`ticketid` AS
                `" . Index::TICKET_ID . "`
        FROM
            `tickets_tickets`
        LEFT JOIN
            `tickets_categories_list`
                ON
                    `tickets_categories_list`.`categoryid`
                        =
                    `tickets_tickets`.`categoryid`
                        AND
                    `tickets_categories_list`.`categoryname`
                        =
                    '" . Ticket::CATEGORY_NAME . "'
        LEFT JOIN
            (
                SELECT
                    `users`.`uid`,
                    `users`.`phone`,
                    `users`.`mob_tel`,
                    `users`.`sms_tel`
                FROM
                    `users`
                UNION
                SELECT
                    `usersfreeze`.`uid`,
                    `usersfreeze`.`phone`,
                    `usersfreeze`.`mob_tel`,
                    `usersfreeze`.`sms_tel`
                FROM
                    `usersfreeze`
                UNION
                SELECT
                    `usersblok`.`uid`,
                    `usersblok`.`phone`,
                    `usersblok`.`mob_tel`,
                    `usersblok`.`sms_tel`
                FROM
                    `usersblok`
                UNION
                SELECT
                    `usersdel`.`uid`,
                    `usersdel`.`phone`,
                    `usersdel`.`mob_tel`,
                    `usersdel`.`sms_tel`
                FROM
                    `usersdel`
            ) AS
                `clients`
                ON
                    `clients`.`uid` = `tickets_tickets`.`useruid`
        WHERE
            `tickets_tickets`.`created_by_stuffid` = 0
                AND
            `tickets_tickets`.`created_by_useruid` = 0
                AND
            `tickets_categories_list`.`categoryid` IS NOT NULL
                AND
            `tickets_tickets`.`prioritytypeid` = " . Ticket::PRIORITY_TYPE_ID . "
                AND
            `tickets_tickets`.`statustypeid` != 2
                AND
            `tickets_tickets`.`show_ticket_to_user` = 1
                AND
            `tickets_tickets`.`dialogue` = 1
                AND
            (
                `tickets_tickets`.`phones` = " . Holder::C_ID . "
                    OR
                `clients`.`phone` = " . Holder::C_ID . "
                    OR
                `clients`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `clients`.`sms_tel` = " . Holder::C_ID . "
            )
        ORDER BY
            `tickets_tickets`.`creationdate`
        DESC
        LIMIT
            1";

    /**
     * Добавление тикета
     */
    public const ADD_TICKET = "
        INSERT INTO
            `tickets_tickets` (
                `useruid`,
                `fio`,
                `street`,
                `settlementname`,
                `neighborhoodname`,
                `house`,
                `apartment`,
                `housingname`,
                `houseblockname`,
                `phones`,
                `categoryid`,
                `prioritytypeid`,
                `show_ticket_to_user`,
                `dialogue`
            )
        VALUES (
            (
                SELECT
                    @uid :=
                    IF(
                        COUNT(
                            `clients`.`uid`
                        ) = 0,
                        0, `clients`.`uid`
                    )
                FROM
                    (
                        SELECT
                            `users`.`uid`,
                            `users`.`phone`,
                            `users`.`mob_tel`,
                            `users`.`sms_tel`
                        FROM
                            `users`
                        UNION
                        SELECT
                            `usersfreeze`.`uid`,
                            `usersfreeze`.`phone`,
                            `usersfreeze`.`mob_tel`,
                            `usersfreeze`.`sms_tel`
                        FROM
                            `usersfreeze`
                        UNION
                        SELECT
                            `usersblok`.`uid`,
                            `usersblok`.`phone`,
                            `usersblok`.`mob_tel`,
                            `usersblok`.`sms_tel`
                        FROM
                            `usersblok`
                        UNION
                        SELECT
                            `usersdel`.`uid`,
                            `usersdel`.`phone`,
                            `usersdel`.`mob_tel`,
                            `usersdel`.`sms_tel`
                        FROM
                            `usersdel`
                    ) AS
                        `clients`
                WHERE
                    (
                        `clients`.`phone` = (
                            @cid := " . Holder::C_ID . "
                        )
                            OR
                        `clients`.`mob_tel` = @cid
                            OR
                        `clients`.`sms_tel` = @cid
                    )
                LIMIT
                    1
            ),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            IF(
                @uid = 0,
                @cid,
                ''
            ),
            (
                SELECT
                    `tickets_categories_list`.`categoryid`
                FROM
                    `tickets_categories_list`
                WHERE
                    `tickets_categories_list`.`categoryname`
                        =
                    '" . Ticket::CATEGORY_NAME . "'
                LIMIT
                    1
            ),
            " . Ticket::PRIORITY_TYPE_ID . ",
            1,
            1
        )";

    /**
     * Добавление примечания к тикету
     */
    public const ADD_NOTE = "
        INSERT INTO
            `tickets_notes` (
                `ticketid`,
                `stuffid`,
                `note`
            )
        VALUES (
            " . Holder::TICKET_ID . ",
            0,
            " . Holder::TICKET_NOTE . "
        )";

    /**
     * Проверка клиента
     */
    public const CHECK_CLIENT = "
        SELECT
            `clients`.`uid` AS
                `" . Index::U_ID . "`,
            `clients`.`user` AS
                `" . Index::LOGIN . "`,
            `clients`.`password` AS
                `" . Index::PASSWORD . "`,
            SUBSTRING(
                `clients`.`fio`,
                LOCATE(
                    ' ', `clients`.`fio`
                ) + 1
            ) AS
                `" . Index::NAME . "`
        FROM
            (
                SELECT
                    `users`.`user`,
                    `users`.`password`,
                    `users`.`uid`,
                    `users`.`fio`,
                    `users`.`phone`,
                    `users`.`mob_tel`,
                    `users`.`sms_tel`
                FROM
                    `users`
                UNION
                SELECT
                    `usersfreeze`.`user`,
                    `usersfreeze`.`password`,
                    `usersfreeze`.`uid`,
                    `usersfreeze`.`fio`,
                    `usersfreeze`.`phone`,
                    `usersfreeze`.`mob_tel`,
                    `usersfreeze`.`sms_tel`
                FROM
                    `usersfreeze`
                UNION
                SELECT
                    `usersblok`.`user`,
                    `usersblok`.`password`,
                    `usersblok`.`uid`,
                    `usersblok`.`fio`,
                    `usersblok`.`phone`,
                    `usersblok`.`mob_tel`,
                    `usersblok`.`sms_tel`
                FROM
                    `usersblok`
            ) AS
                `clients`
        WHERE
            (
                `clients`.`phone` = " . Holder::C_ID . "
                    OR
                `clients`.`mob_tel` = " . Holder::C_ID . "
                    OR
                `clients`.`sms_tel` = " . Holder::C_ID . "
            )
                AND
            `clients`.`fio` != ''
                AND
            `clients`.`user` != ''
                AND
            `clients`.`password` != ''
                AND
            `clients`.`password` != '*'
        LIMIT
            1";

    /**
     * Добавление сообщения тикета
     */
    public const ADD_MESSAGE = "
        INSERT INTO
            `tickets_messages` (
                `ticketid`,
                `stuffid`,
                `useruid`,
                `message`,
                `unread`
            )
        VALUES (
            " . Holder::TICKET_ID . ",
            0,
            0,
            " . Holder::TICKET_MESSAGE . ",
            1
        )";

    /**
     * Добавление СМС-сообщения
     */
    public const LOG_MESSAGE = "
        INSERT INTO
            `sms_logs` (
                `sms_type_id`,
                `uid`,
                `sms_phone`,
                `sms_text`,
                `sms_error_text`
            )
        VALUES (
            0,
            " . Holder::U_ID . ",
            " . Holder::C_ID . ",
            " . Holder::SMS_TEXT. ",
            " . Holder::SMS_ERROR_TEXT . "
        )";
}
