<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

/**
 * Путь к конфигурационному файлу MikBill
 * @link https://wiki.mikbill.pro/billing/config_file
 */
const CONFIG =  '/var/www/mikbill/admin/app/etc/config.xml';

require_once '/var/mikbill/__ext/vendor/autoload.php';

use Panda\MikBill\Pbx\AssistantApi;

$logic = new AssistantApi\Logic;

try {
    $logic->run();

    header($logic->contentType);
    header($logic->status);
    print_r($logic->content);
} catch (AssistantApi\Exception\SystemException $e) {
    header(AssistantApi\Content::APPLICATION_JSON);
    header(AssistantApi\Status::INTERNAL_500);
    print_r(AssistantApi\Response::getError(
        AssistantApi\Code::SYSTEM_ERROR,
        $e->getMessage()));
} catch (AssistantApi\Exception\DebugException $e) {
    header(AssistantApi\Content::APPLICATION_JSON);
    header(AssistantApi\Status::INTERNAL_500);
    print_r(AssistantApi\Response::getError(
        AssistantApi\Code::DEBUG_ERROR,
        $e->getMessage()));
}
