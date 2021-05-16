# MikBill-VPBX-Assistant-API

API для интеграции биллинговой системы ["MikBill"](https://mikbill.pro) с сервисами IP-телефонии

[![Packagist Downloads](https://img.shields.io/packagist/dt/itpanda-llc/mikbill-vpbx-assistant-api)](https://packagist.org/packages/itpanda-llc/mikbill-vpbx-assistant-api/stats)
![Packagist License](https://img.shields.io/packagist/l/itpanda-llc/mikbill-vpbx-assistant-api)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/itpanda-llc/mikbill-vpbx-assistant-api)

## Ссылки

* [Разработка](https://github.com/itpanda-llc)
* [О проекте (MikBill)](https://mikbill.pro)
* [Документация (MikBill)](https://wiki.mikbill.pro)

## Возможности

* Приветствие
* Информация (состояния аккаунта, ожидание, обратный вызов)
* Представление
* Промо
* Извинение

## Требования

* [SoX](http://sox.sourceforge.net/)
* [LAME](http://lame.sourceforge.net/)
* PHP >= 7.2
* JSON
* libxml
* PDO
* SimpleXML
* [itpanda-llc/yandex-speechkit-sdk](https://github.com/itpanda-llc/yandex-speechkit-sdk)
* [itpanda-llc/yandex-translate-sdk](https://github.com/itpanda-llc/yandex-translate-sdk)

## Установка

```shell script
composer require itpanda-llc/mikbill-vpbx-assistant-api
```

## Конфигурация

Установка "SoX", "LAME"

```shell script
yum install -e sox
yum install -e lame
```

Указание в файлах

* Словарного запаса в ["Dictionary"](src/Dictionary)
* Параметров аутентификации в ["Auth.php"](src/Auth.php)
* Параметров сервиса ["Yandex Cloud"](https://cloud.yandex.ru) в ["Cloud.php"](src/Cloud.php)
* Путей к [конфигурационному файлу](https://wiki.mikbill.pro/billing/config_file) и интерфейсам в ["index.php"](examples/www/mikbill/admin/api/vpbx/assistant/index.php), предварительно размещенного в каталоге веб-сервера

## Примеры запросов к интерфейсу

### Регулярный пример

Русский язык, произвольный премум-голос, MPEG-формат

```text
%URL%?secret=%SECRET%&type=regular&format=mpeg&c_id=%C_ID%
```

### Приветствия

Русский язык, произвольный премум-голос, MPEG-формат

```text
%URL%?secret=%SECRET%&type=greeting&format=mpeg&c_id=%C_ID%
```

Русский язык, голос "Филипп", Wav-формат

```text
%URL%?secret=%SECRET%&type=greeting&lang=ru-RU&voice=filipp&format=wav&c_id=%C_ID%
```

### Сообщения об обратном вызове

Английский язык, голос "Alyss", Wav-формат

```text
%URL%?secret=%SECRET%&type=callback&lang=en-US&voice=alyss&format=wav
```
