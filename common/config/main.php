<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('CASUAL_POSTGRES_DSN'),
            'username' => getenv('CASUAL_POSTGRES_USER'),
            'password' => getenv('CASUAL_POSTGRES_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'telegram' => [
            'class' => \common\components\Telegram::class,
            'apiUrl' => getenv('TELEGRAM_API_URL'),
            'botId' => getenv('TELEGRAM_BOT_ID'),
            'chatId' => getenv('TELEGRAM_CHAT_ID'),
        ]
    ],
];
