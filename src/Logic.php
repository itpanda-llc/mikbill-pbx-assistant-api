<?php

/**
 * Файл из репозитория MikBill-VirtualPBX-PHP-API
 * @link https://github.com/itpanda-llc
 */

namespace Panda\MikBill\VirtualPBXAPI;

use Panda\MikBill\VirtualPBXAPI\Dictionary\Block;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Callback;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Defect;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Delete;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Freeze;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Present;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Promo;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Sorry;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Stop;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Wait;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Welcome;
use Panda\MikBill\VirtualPBXAPI\Dictionary\Work;
use Panda\MikBill\VirtualPBXAPI\Exception\DebugException;

use Panda\SMSPilot\MessengerSDK\Format as MessengerSDKFormat;
use Panda\SMSPilot\MessengerSDK\Pilot;
use Panda\SMSPilot\MessengerSDK\Singleton;
use Panda\SMSPilot\MessengerSDK\Exception\ClientException
    as MessengerSDKException;

use Panda\Yandex\SpeechKitSDK\Cloud;
use Panda\Yandex\SpeechKitSDK\Emotion;
use Panda\Yandex\SpeechKitSDK\En;
use Panda\Yandex\SpeechKitSDK\Format as SpeechKitSDKFormat;
use Panda\Yandex\SpeechKitSDK\Lang;
use Panda\Yandex\SpeechKitSDK\Premium;
use Panda\Yandex\SpeechKitSDK\Rate;
use Panda\Yandex\SpeechKitSDK\Ru;
use Panda\Yandex\SpeechKitSDK\Speech;
use Panda\Yandex\SpeechKitSDK\Tr;
use Panda\Yandex\SpeechKitSDK\Exception\ClientException
    as SpeechKitSDKException;

/**
 * Class Logic
 * @package Panda\MikBill\VirtualPBXAPI
 * Проверка запроса и формирование ответа
 */
class Logic
{
    /**
     * @var string|null Секрет
     */
    private $secret;

    /**
     * @var string|null Тип запроса
     */
    private $type;

    /**
     * @var string|null Формат ответа
     */
    private $format;

    /**
     * @var string|null Язык
     */
    private $lang;

    /**
     * @var string|null Голос
     */
    private $voice;

    /**
     * @var string|null Номер телефона
     */
    private $cId;

    /**
     * @var string Тип контента
     */
    private $contentType = Content::JSON_TYPE;

    /**
     * @var string Статус ответа
     */
    private $status = Status::BAD_REQUEST_400;

    /**
     * @var string|null Контент
     */
    private $content;

    /**
     * Logic constructor.
     * Подготовка к обработке запроса
     */
    public function __construct()
    {
        $query = (empty($_GET)) ? $_POST : $_GET;

        $this->secret = (!empty($query[Param::SECRET]))
            ? $query[Param::SECRET]
            : null;
        $this->type = (!empty($query[Param::TYPE]))
            ? $query[Param::TYPE]
            : null;
        $this->format = (!empty($query[Param::FORMAT]))
            ? $query[Param::FORMAT]
            : null;
        $this->lang = (!empty($query[Param::LANG]))
            ? $query[Param::LANG]
            : null;
        $this->voice = (!empty($query[Param::VOICE]))
            ? $query[Param::VOICE]
            : null;
        $this->cId = (!empty($query[Param::CID]))
            ? $query[Param::CID]
            : null;
    }

    /**
     * Проверка параметров запроса и формирование ответа
     */
    public function run(): void
    {
        try {
            $secrets = (new \ReflectionClass(Auth::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new DebugException($e->getMessage());
        }

        if (!in_array($this->secret, $secrets, true)) {
            $this->content = Response::getError(Code::ERROR,
                Message::SECRET_ERROR);

            return;
        }

        try {
            $types = (new \ReflectionClass(Type::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new DebugException($e->getMessage());
        }

        if (!in_array($this->type, $types, true)) {
            $this->content = Response::getError(Code::ERROR,
                Message::TYPE_ERROR);

            return;
        }

        if ((is_null($this->cId)) && ($this->type !== Type::CALLBACK)) {
            $this->content = Response::getError(Code::ERROR,
                Message::CID_ERROR);

            return;
        }

        if ($this->type === Type::TICKET) {
            if (!is_null(Query::checkTicket($this->cId))) {
                $this->status = Status::OK_200;
                $this->content = Response::getResult(Message::TICKET_OK);

                return;
            }

            if ((!Query::checkCategory()) && (!Query::addCategory()))
                throw new DebugException(Message::ADD_TICKET_CATEGORY_ERROR);

            Transaction::begin();

            if ((!Query::addTicket($this->cId))
                || (is_null($ticket = Query::checkTicket($this->cId))))
            {
                Transaction::rollBack();

                throw new DebugException(Message::ADD_TICKET_ERROR);
            }

            if (!Query::addNote($ticket[Index::TICKET_ID], Ticket::NOTE)) {
                Transaction::rollBack();

                throw new DebugException(Message::ADD_TICKET_NOTE_ERROR);
            }

            if (!is_null($client = Query::checkClient($this->cId))) {
                $message = Text::get(Ticket::getIntro(),
                    sprintf("%s!", $client[Index::NAME]),
                    Ticket::getSample());

                if (!Query::addMessage($ticket[Index::TICKET_ID], $message)) {
                    Transaction::rollBack();

                    throw new DebugException(Message::ADD_TICKET_MESSAGE_ERROR);
                }

                Transaction::commit();

                $message = Text::get(
                    sprintf("%s,", $client[Index::NAME]),
                    SMS::getSample(),
                    sprintf("%s.", SMS::COMPANY_NAME),
                    SMS::getOutro(),
                    sprintf("%s?l=%s&p=%s&lang=%s",
                        SMS::CABINET_URL,
                        $client[Index::LOGIN],
                        $client[Index::PASSWORD],
                        SMS::CABINET_LANG));

                $pilot = new Pilot(
                    \Panda\MikBill\VirtualPBXAPI\Pilot::API_KEY);

                $singleton = new Singleton($message, $this->cId);

                $singleton->setName(
                    \Panda\MikBill\VirtualPBXAPI\Pilot::SEND_NAME)
                    ->addParam(MessengerSDKFormat::get(
                        MessengerSDKFormat::JSON));

                try {
                    $j = json_decode($pilot->request($singleton));
                } catch (MessengerSDKException $e) {
                    $error = SMS::ERROR_TEXT;
                }

                $error = $error ?? $j->error->description ?? '';

                if (!Query::logMessage($client[Index::U_ID],
                    $this->cId, $message, $error))
                {
                    throw new DebugException(Message::ADD_SMS_MESSAGE_ERROR);
                }
            } else {
                Transaction::commit();
            }

            $this->status = Status::OK_200;
            $this->content = Response::getResult(Message::TICKET_OK);

            return;
        }

        $this->format = $this->format ?? Format::TEXT;

        try {
            $formats = (new \ReflectionClass(Format::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new DebugException($e->getMessage());
        }

        if (!in_array($this->format, $formats, true)) {
            $this->content = Response::getError(Code::ERROR,
                Message::FORMAT_ERROR);

            return;
        }

        if ((!is_null($this->lang)) && ($this->format !== Format::TEXT)) {
            try {
                $langs = (new \ReflectionClass(Lang::class))->getConstants();
            } catch (\ReflectionException $e) {
                throw new DebugException($e->getMessage());
            }

            if (!in_array($this->lang, $langs)) {
                $this->content = Response::getError(Code::ERROR,
                    Message::LANG_ERROR);

                return;
            }
        }

        if ((!is_null($this->voice)) && ($this->format !== Format::TEXT)) {
            try {
                $voices = array_merge(
                    (new \ReflectionClass(En::class))->getConstants(),
                    (new \ReflectionClass(Ru::class))->getConstants(),
                    (new \ReflectionClass(Tr::class))->getConstants(),
                    (new \ReflectionClass(Premium::class))->getConstants());
            } catch (\ReflectionException $e) {
                throw new DebugException($e->getMessage());
            }

            if (!in_array($this->voice, $voices)) {
                $this->content = Response::getError(Code::ERROR,
                    Message::VOICE_ERROR);

                return;
            }
        } else {
            switch (true) {
                case ($this->lang === Lang::RU):
                    try {
                        $this->voice = Ru::random();
                    } catch (SpeechKitSDKException $e) {
                        throw new DebugException($e->getMessage());
                    }

                    break;
                case ($this->lang === Lang::EN):
                    try {
                        $this->voice = En::random();
                    } catch (SpeechKitSDKException $e) {
                        throw new DebugException($e->getMessage());
                    }

                    break;
                case ($this->lang === Lang::TR):
                    try {
                        $this->voice = Tr::random();
                    } catch (SpeechKitSDKException $e) {
                        throw new DebugException($e->getMessage());
                    }

                    break;
                default:
                    $this->lang = Lang::RU;

                    try {
                        $this->voice = Premium::random();
                    } catch (SpeechKitSDKException $e) {
                        throw new DebugException($e->getMessage());
                    }
            }
        }

        if ($this->type === Type::CALLBACK) {
            $text = Text::get(Callback::getIntro(),
                Callback::getSample(),
                Callback::getOutro());
        }

        if ($this->type === Type::WELCOME) {
            switch (true) {
                case (!is_null($client = Query::checkStop($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.", $client[Index::NAME]),
                        Stop::getSample(),
                        Stop::getOutro(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkBlock($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.", $client[Index::NAME]),
                        Block::getIntro(),
                        Block::getSample(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkDelete($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.", $client[Index::NAME]),
                        Delete::getIntro(),
                        Delete::getSample(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkFreeze($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.", $client[Index::NAME]),
                        Freeze::getIntro(),
                        Freeze::getSample(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkWork($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.",$client[Index::NAME]),
                        Work::getSample(),
                        Work::getOutro(),
                        Sorry::getSample(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkDefect($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s.", $client[Index::NAME]),
                        Defect::getIntro(),
                        sprintf("%s,", $client[Index::ADDRESS]),
                        Defect::getSample(),
                        (($time = $client[Index::TIME]) !== '0')
                            ? sprintf("%s %s.", $time, Defect::MINUTES_LEFT_OUTRO)
                            : sprintf("%s.", Defect::PRESENT_HOUR_OUTRO),
                        Sorry::getSample(),
                        Wait::getSample());

                    break;
                case (!is_null($client = Query::checkActive($this->cId))):
                    $text = Text::get(Welcome::getSample(),
                        sprintf("%s!", $client[Index::NAME]),
                        Promo::getSample(),
                        Wait::getSample());

                    if ($this->format !== Format::TEXT)
                        $emotion = Emotion::GOOD;

                    break;
                default:
                    $text = Text::get(Present::getSample(),
                        Wait::getSample());

                    if ($this->format !== Format::TEXT)
                        $emotion = Emotion::GOOD;
            }
        }

        if ($this->format === Format::TEXT) {
            $this->status = Status::OK_200;
            $this->content = Response::getResult($text);

            return;
        }

        try {
            $cloud = new Cloud(\Panda\MikBill\VirtualPBXAPI\Cloud::OAUTH_TOKEN,
                \Panda\MikBill\VirtualPBXAPI\Cloud::FOLDER_ID);
        } catch (SpeechKitSDKException $e) {
            throw new DebugException($e->getMessage());
        }

        try {
            $speech = new Speech($text);
        } catch (SpeechKitSDKException $e) {
            throw new DebugException($e->getMessage());
        }

        if (!is_null($this->lang)) $speech->setLang($this->lang);

        $speech->setVoice($this->voice)
            ->setEmotion($emotion ?? Emotion::NEUTRAL);

        if ($this->format !== Format::OGGOPUS) {
            $speech->setFormat(SpeechKitSDKFormat::LPCM)
                ->setRate(Rate::HIGH);
        } else {
            $speech->setFormat(SpeechKitSDKFormat::OGGOPUS);
        }

        try {
            $response = $cloud->request($speech);
        } catch (SpeechKitSDKException $e) {
            throw new DebugException($e->getMessage());
        }

        if ($this->format === Format::LPCM) {
            $this->contentType = Content::L16_TYPE;
            $this->status = Status::OK_200;
            $this->content = $response;

            return;
        }

        if ($this->format === Format::OGGOPUS) {
            $this->contentType = Content::OGG_TYPE;
            $this->status = Status::OK_200;
            $this->content = $response;

            return;
        }

        if ($this->format === Format::WAV) {
            $this->contentType = Content::WAV_TYPE;
            $this->status = Status::OK_200;
            $this->content = Audio::getWav($response);;

            return;
        }

        if ($this->format === Format::MPEG) {
            $this->contentType = Content::MPEG_TYPE;
            $this->status = Status::OK_200;
            $this->content = Audio::getMPEG(Audio::getWav($response));

            return;
        }
    }

    /**
     * @return string Тип контента
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return string Статус ответа
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string Контент
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
