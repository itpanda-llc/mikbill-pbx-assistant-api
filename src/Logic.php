<?php

/**
 * Файл из репозитория MikBill-PBX-Assistant-API
 * @link https://github.com/itpanda-llc/mikbill-pbx-assistant-api
 */

declare(strict_types=1);

namespace Panda\MikBill\Pbx\AssistantApi;

use Panda\Yandex\SpeechKitSdk;
use Panda\Yandex\TranslateSdk;

/**
 * Class Logic
 * @package Panda\MikBill\Pbx\AssistantApi
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
    public $contentType = Content::APPLICATION_JSON;

    /**
     * @var string Статус ответа
     */
    public $status = Status::OK_200;

    /**
     * @var string|null Контент
     */
    public $content;

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
        $this->cId = (!empty($query[Param::C_ID]))
            ? $query[Param::C_ID]
            : null;
    }

    public function run(): void
    {
        try {
            $secrets = (new \ReflectionClass(Auth::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        if (!in_array($this->secret, $secrets, true)) {
            $this->status = Status::FORBIDDEN_403;
            $this->content = Response::getError(Code::REQUEST_ERROR,
                Message::SECRET_ERROR);

            return;
        }

        $this->type = $this->type ?? Type::REGULAR;

        try {
            $types = (new \ReflectionClass(Type::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        if (!in_array($this->type, $types, true)) {
            $this->status = Status::BAD_REQUEST_400;
            $this->content = Response::getError(Code::REQUEST_ERROR,
                Message::TYPE_ERROR);

            return;
        }

        $this->format = $this->format ?? Format::TEXT;

        try {
            $formats = (new \ReflectionClass(Format::class))->getConstants();
        } catch (\ReflectionException $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        if (!in_array($this->format, $formats, true)) {
            $this->status = Status::BAD_REQUEST_400;
            $this->content = Response::getError(Code::REQUEST_ERROR,
                Message::FORMAT_ERROR);

            return;
        }

        if (!is_null($this->lang)) {
            try {
                $langs = (new \ReflectionClass(SpeechKitSdk\Lang::class))
                    ->getConstants();
            } catch (\ReflectionException $e) {
                throw new Exception\DebugException($e->getMessage());
            }

            try {
                $translateCloud =
                    (defined('\Panda\MikBill\Pbx\AssistantApi\Cloud::API_KEY'))
                        ? TranslateSdk\Cloud::createApi(Cloud::API_KEY)
                        : new TranslateSdk\Cloud(Cloud::OAUTH_TOKEN, Cloud::FOLDER_ID);
            } catch (TranslateSdk\Exception\ClientException | \TypeError $e) {
                throw new Exception\DebugException($e->getMessage());
            }

            if ($this->format === Format::TEXT) {
                try {
                    $response = json_decode(
                        $translateCloud->request(new TranslateSdk\Languages));
                } catch (TranslateSdk\Exception\ClientException $e) {
                    throw new Exception\DebugException($e->getMessage());
                }

                $langs = array_merge($langs,
                    array_map(function(\stdClass $a) { return $a->code; },
                        $response->languages));
            }

            if (!in_array($this->lang, $langs, true)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::REQUEST_ERROR,
                    Message::LANG_ERROR);

                return;
            }
        }

        if ($this->format !== Format::TEXT)
            if (!is_null($this->voice)) {
                try {
                    $voices = array_merge(
                        (new \ReflectionClass(SpeechKitSdk\Voice\En::class))
                            ->getConstants(),
                        (new \ReflectionClass(SpeechKitSdk\Voice\Ru::class))
                            ->getConstants(),
                        (new \ReflectionClass(SpeechKitSdk\Voice\Tr::class))
                            ->getConstants(),
                        (new \ReflectionClass(SpeechKitSdk\Voice\Premium::class))
                            ->getConstants());
                } catch (\ReflectionException $e) {
                    throw new Exception\DebugException($e->getMessage());
                }

                if (!in_array($this->voice, $voices, true)) {
                    $this->status = Status::BAD_REQUEST_400;
                    $this->content = Response::getError(Code::REQUEST_ERROR,
                        Message::VOICE_ERROR);

                    return;
                }
            } else
                try {
                    switch (true) {
                        case ($this->lang === SpeechKitSdk\Lang::RU_RU):
                            $this->voice = SpeechKitSdk\Voice\Ru::random();

                            break;
                        case ($this->lang === SpeechKitSdk\Lang::EN_US):
                            $this->voice = SpeechKitSdk\Voice\En::random();

                            break;
                        case ($this->lang === SpeechKitSdk\Lang::TR_TR):
                            $this->voice = SpeechKitSdk\Voice\Tr::random();

                            break;
                        default:
                            $this->lang = SpeechKitSdk\Lang::RU_RU;
                            $this->voice = SpeechKitSdk\Voice\Premium::random();
                    }
                } catch (SpeechKitSdk\Exception\ClientException $e) {
                    throw new Exception\DebugException($e->getMessage());
                }

        if ($this->type === Type::REGULAR) {
            if (is_null($this->cId)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::REQUEST_ERROR,
                    Message::C_ID_ERROR);

                return;
            }

            switch (true) {
                case (!is_null($client = Query::checkStop($this->cId))):
                    $text = sprintf("%s %s. %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Stop::getSample(),
                        Dictionary\Ru\Stop::getOutro(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkBlock($this->cId))):
                    $text = sprintf("%s %s. %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Block::getIntro(),
                        Dictionary\Ru\Block::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkDelete($this->cId))):
                    $text = sprintf("%s %s. %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Delete::getIntro(),
                        Dictionary\Ru\Delete::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkFreeze($this->cId))):
                    $text = sprintf("%s %s. %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Freeze::getIntro(),
                        Dictionary\Ru\Freeze::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkWork($this->cId))):
                    $text = sprintf("%s %s. %s %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Work::getSample(),
                        Dictionary\Ru\Work::getOutro(),
                        Dictionary\Ru\Sorry::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkDefect($this->cId))):
                    $text = sprintf("%s %s. %s %s, %s %s %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Defect::getIntro(),
                        $client[Field::ADDRESS],
                        Dictionary\Ru\Defect::getSample(),
                        (($time = $client[Field::TIME]) !== '0')
                            ? sprintf("%s %s",
                                $time,
                                Dictionary\Ru\Defect::MINUTES_LEFT_OUTRO)
                            : Dictionary\Ru\Defect::PRESENT_HOUR_OUTRO,
                        Dictionary\Ru\Sorry::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    break;
                case (!is_null($client = Query::checkActive($this->cId))):
                    $text = sprintf("%s %s! %s %s",
                        Dictionary\Ru\Welcome::getSample(),
                        $client[Field::NAME],
                        Dictionary\Ru\Promo::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    if ($this->format !== Format::TEXT)
                        $emotion = SpeechKitSdk\Emotion::GOOD;

                    break;
                default:
                    $text = sprintf("%s %s",
                        Dictionary\Ru\Present::getSample(),
                        Dictionary\Ru\Wait::getSample());

                    if ($this->format !== Format::TEXT)
                        $emotion = SpeechKitSdk\Emotion::GOOD;
            }
        }

        if ($this->type === Type::PRESENT) {
            $text = Dictionary\Ru\Present::getSample();

            if ($this->format !== Format::TEXT)
                $emotion = SpeechKitSdk\Emotion::GOOD;
        }

        if ($this->type === Type::PROMO) {
            $text = Dictionary\Ru\Promo::getSample();

            if ($this->format !== Format::TEXT)
                $emotion = SpeechKitSdk\Emotion::GOOD;
        }

        if ($this->type === Type::GREETING) {
            if (is_null($this->cId)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::REQUEST_ERROR,
                    Message::C_ID_ERROR);

                return;
            }

            if (!is_null($client = Query::checkClient($this->cId)))
                $text = sprintf("%s %s! %s",
                    Dictionary\Ru\Welcome::getSample(),
                    $client[Field::NAME],
                    Dictionary\Ru\Promo::getSample());
            else
                $text = Dictionary\Ru\Present::getSample();

            if (($this->format !== Format::TEXT)
                && (is_null(Query::checkStop($this->cId)))
                && (is_null(Query::checkBlock($this->cId)))
                && (is_null(Query::checkDelete($this->cId)))
                && (is_null(Query::checkFreeze($this->cId)))
                && (is_null(Query::checkWork($this->cId)))
                && (is_null(Query::checkDefect($this->cId))))
                $emotion = SpeechKitSdk\Emotion::GOOD;
        }

        if ($this->type === Type::INFO) {
            if (is_null($this->cId)) {
                $this->status = Status::BAD_REQUEST_400;
                $this->content = Response::getError(Code::REQUEST_ERROR,
                    Message::C_ID_ERROR);

                return;
            }

            switch (true) {
                case (!is_null(Query::checkStop($this->cId))):
                    $text = sprintf("%s %s",
                        Dictionary\Ru\Stop::getSample(),
                        Dictionary\Ru\Stop::getOutro());

                    break;
                case (!is_null(Query::checkBlock($this->cId))):
                    $text = sprintf("%s %s",
                        Dictionary\Ru\Block::getIntro(),
                        Dictionary\Ru\Block::getSample());

                    break;
                case (!is_null(Query::checkDelete($this->cId))):
                    $text = sprintf("%s %s",
                        Dictionary\Ru\Delete::getIntro(),
                        Dictionary\Ru\Delete::getSample());

                    break;
                case (!is_null(Query::checkFreeze($this->cId))):
                    $text = sprintf("%s %s",
                        Dictionary\Ru\Freeze::getIntro(),
                        Dictionary\Ru\Freeze::getSample());

                    break;
                case (!is_null(Query::checkWork($this->cId))):
                    $text = sprintf("%s %s %s",
                        Dictionary\Ru\Work::getSample(),
                        Dictionary\Ru\Work::getOutro(),
                        Dictionary\Ru\Sorry::getSample());

                    break;
                case (!is_null($client = Query::checkDefect($this->cId))):
                    $text = sprintf("%s %s, %s %s %s",
                        Dictionary\Ru\Defect::getIntro(),
                        $client[Field::ADDRESS],
                        Dictionary\Ru\Defect::getSample(),
                        (($time = $client[Field::TIME]) !== '0')
                            ? sprintf("%s %s",
                                $time,
                                Dictionary\Ru\Defect::MINUTES_LEFT_OUTRO)
                            : Dictionary\Ru\Defect::PRESENT_HOUR_OUTRO,
                        Dictionary\Ru\Sorry::getSample());

                    break;
                case (!is_null(Query::checkActive($this->cId))):
                    $text = Dictionary\Ru\Promo::getSample();

                    if ($this->format !== Format::TEXT)
                        $emotion = SpeechKitSdk\Emotion::GOOD;

                    break;
                default:
                    $text = Dictionary\Ru\Present::getSample();

                    if ($this->format !== Format::TEXT)
                        $emotion = SpeechKitSdk\Emotion::GOOD;
            }
        }

        if ($this->type === Type::WAITING) {
            $text = Dictionary\Ru\Wait::getSample();

            if ((!is_null($this->cId))
                && ($this->format !== Format::TEXT)
                && (is_null(Query::checkStop($this->cId)))
                && (is_null(Query::checkBlock($this->cId)))
                && (is_null(Query::checkDelete($this->cId)))
                && (is_null(Query::checkFreeze($this->cId)))
                && (is_null(Query::checkWork($this->cId)))
                && (is_null(Query::checkDefect($this->cId))))
                $emotion = SpeechKitSdk\Emotion::GOOD;
        }

        if ($this->type === Type::CALLBACK)
            $text = sprintf("%s %s %s",
                Dictionary\Ru\Callback::getIntro(),
                Dictionary\Ru\Callback::getSample(),
                Dictionary\Ru\Callback::getOutro());

        if ($this->type === Type::BLOCK)
            $text = sprintf("%s %s",
                Dictionary\Ru\Block::getIntro(),
                Dictionary\Ru\Block::getSample());

        if ($this->type === Type::DELETE)
            $text = sprintf("%s %s",
                Dictionary\Ru\Delete::getIntro(),
                Dictionary\Ru\Delete::getSample());

        if ($this->type === Type::FREEZE)
            $text = sprintf("%s %s",
                Dictionary\Ru\Freeze::getIntro(),
                Dictionary\Ru\Freeze::getSample());

        if ($this->type === Type::APOLOGY)
            $text = Dictionary\Ru\Sorry::getSample();

        if ($this->type === Type::STOP)
            $text = sprintf("%s %s",
                Dictionary\Ru\Stop::getSample(),
                Dictionary\Ru\Stop::getOutro());

        if ($this->type === Type::WORK)
            $text = sprintf("%s %s",
                Dictionary\Ru\Work::getSample(),
                Dictionary\Ru\Work::getOutro());

        if ((!is_null($this->lang))
            && ($this->lang !== SpeechKitSdk\Lang::RU_RU)
            && ($this->lang !== 'ru'))
        {
            try {
                $translate = new TranslateSdk\Translate(str_replace('+', '', $text));

                switch (true) {
                    case ($this->lang === SpeechKitSdk\Lang::EN_US):
                        $translate->setTargetLang('en');

                        break;
                    case ($this->lang === SpeechKitSdk\Lang::TR_TR):
                        $translate->setTargetLang('tr');

                        break;
                    default:
                        $translate->setTargetLang($this->lang);
                }

                $response = json_decode($translateCloud->request($translate));
            } catch (TranslateSdk\Exception\ClientException $e) {
                throw new Exception\DebugException($e->getMessage());
            }

            $text = (string) $response->translations[0]->text;
        }

        if ($this->format === Format::TEXT) {
            $this->content = Response::getResult($text);

            return;
        }

        try {
            $speechKitCloud =
                (defined('\Panda\MikBill\Pbx\AssistantApi\Cloud::API_KEY'))
                    ? SpeechKitSdk\Cloud::createApi(Cloud::API_KEY)
                    : new SpeechKitSdk\Cloud(Cloud::OAUTH_TOKEN, Cloud::FOLDER_ID);

            $synthesize = new SpeechKitSdk\Synthesize($text);
        } catch (SpeechKitSdk\Exception\ClientException | \TypeError $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        $synthesize->setLang($this->lang)
            ->setVoice($this->voice);

        if ((isset($emotion))
            && (($this->lang === SpeechKitSdk\Lang::RU_RU)
                || ($this->voice === SpeechKitSdk\Voice\Ru::JANE)
                || ($this->voice === SpeechKitSdk\Voice\Ru::OMAZH)))
        {
            try {
                $premium = (new \ReflectionClass(
                    SpeechKitSdk\Voice\Premium::class))->getConstants();
            } catch (\ReflectionException $e) {
                throw new Exception\DebugException($e->getMessage());
            }

            if (!in_array($this->voice, $premium, true))
                $synthesize->setEmotion($emotion);
        }

        if ($this->format !== Format::OGGOPUS)
            $synthesize->setFormat(SpeechKitSdk\Format::LPCM)
                ->setSampleRate(SpeechKitSdk\SampleRate::KHZ_48);
        else
            $synthesize->setFormat(SpeechKitSdk\Format::OGGOPUS);

        try {
            $response = $speechKitCloud->request($synthesize);
        } catch (SpeechKitSdk\Exception\ClientException $e) {
            throw new Exception\DebugException($e->getMessage());
        }

        switch (true) {
            case ($this->format === Format::LPCM):
                $this->contentType = Content::AUDIO_L16;
                $this->content = $response;

                return;

            case ($this->format === Format::OGGOPUS):
                $this->contentType = Content::AUDIO_OGG;
                $this->content = $response;

                return;

            case ($this->format === Format::WAV):
                $this->contentType = Content::AUDIO_WAV;
                $this->content = Audio::getWav($response);

                return;

            case ($this->format === Format::MPEG):
                $this->contentType = Content::AUDIO_MPEG;
                $this->content = Audio::getMpeg(Audio::getWav($response));

                return;
        }
    }
}
