<?php

$_ENV['YII_PRODUCT_SETTINGS'] = \yii\helpers\Json::decode(file_get_contents(dirname(dirname(__DIR__)) . '/settings.json'));

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
