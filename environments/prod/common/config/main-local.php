<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('CASUAL_POSTGRES_DSN'),
            'username' => getenv('CASUAL_POSTGRES_USER'),
            'password' => getenv('CASUAL_POSTGRES_PASSWORD'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
