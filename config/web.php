<?php

$params = require(__DIR__ . '/params.php');
$mailer = require(__DIR__ . '/mailer.php');

$config = [
    'id' => 'yii2start',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'app\components\LanguageSelector',
        ],
    ],
    'language'=> 'en',
    'modules' => [
        'user' => [ 
            'class' => 'dektrium\user\Module',
            'admins' => ['dasha']
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
        ],
    ],
    'components' => [
	'urlManager' => [
	    'enablePrettyUrl' => true,
	    'showScriptName' => false,
	    'rules' => [
		'' => 'site/index',
		'<controller:[\w\-]+>' => '<controller>/index',
	    ],
	],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cK_mLtslRMXwcMrw9tkj3vHhJkeAEPY1',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
             'identityClass' => 'app\models\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $mailer,
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],     
            ],
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
