<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=lagrannacion_sistema',
            'username' => 'lagrannacion',
            'password' => 'o8yA9@h4',
            'charset' => 'utf8',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=lagrannacion_imagenes',
            'username' => 'lagrannacion2',
            'password' => 'o8yA9@h4',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'useFileTransport' => false,//falso para envio de correos, verdadero para simular el envio
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'urlManager'=>[
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules'=>[
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\S+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ]
    ],
];
