<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * Load application environment from .env file
 */
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

ini_set('display_errors', (YII_ENV_PROD ? 0 : 1));
ini_set('error_reporting', E_ALL | E_STRICT);

$config = require __DIR__ . '/../config/web.php';

$application = new yii\web\Application($config);
require __DIR__ . '/../config/aliases.php';

$application->run();
