<?php

Yii::setAlias('app', dirname(__DIR__) . DS . 'src');
Yii::setAlias('App', dirname(__DIR__) . DS . 'src');
Yii::setAlias('webroot', dirname(__DIR__) . DS . 'web');

if (php_sapi_name() !== 'cli') {
    $protocol = (stripos($_SERVER['SERVER_PROTOCOL'], 'https') ? 'https' : 'http');
    $baseUrl = "{$protocol}://{$_SERVER['HTTP_HOST']}";

    Yii::setAlias('web', $baseUrl);
}