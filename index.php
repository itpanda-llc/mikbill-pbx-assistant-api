<?php

define ('CONFIG', '../../app/etc/config.xml');

require_once '../../../../../mikbill/__ext/mikbill-virtualpbx-php-api/autoload.php';
require_once '../../../../../mikbill/__ext/yandex-speechkit-php-sdk/autoload.php';
require_once '../../../../../mikbill/__ext/smspilot-messenger-php-sdk/autoload.php';

use Panda\MikBill\VirtualPBXAPI\Logic;
use Panda\MikBill\VirtualPBXAPI\Content;
use Panda\MikBill\VirtualPBXAPI\Status;
use Panda\MikBill\VirtualPBXAPI\Response;
use Panda\MikBill\VirtualPBXAPI\Code;
use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

$logic = new Logic;

try {
    $logic->run();

    header($logic->getContentType());
    header($logic->getStatus());

    print_r($logic->getContent());
} catch (DebugException $e) {
    header(Content::JSON_TYPE);
    header(Status::INTERNAL_500);

    print_r(Response::getError(Code::DEBUG,
        $e->getMessage()));
}
