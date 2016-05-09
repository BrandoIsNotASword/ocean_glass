<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//falso para envio de correos, verdadero para simular el envio
            'transport'=>[
                'class'=>'Swift_SmtpTransport',
                'host'=>'gator3166.hostgator.com',
                'username'=>'test@elmundodegrace.com',
                'password'=>'OGI1tcJqT',
                'port'=>'465',
                'encryption'=>'ssl',
            ],
        ],
    ],
];
