<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=oceanglass',
            'username' => 'root',
            'password' => 'cJrhL7V2',
            'charset' => 'utf8',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=oceanglass_images',
            'username' => 'root',
            'password' => 'cJrhL7V2',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'useFileTransport' => false,//falso para envio de correos, verdadero para simular el envio
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
