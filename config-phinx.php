<?php

use Joeriabbo\OrmMigrationsStandalone\Core\Config;

require_once 'vendor/autoload.php';
$config = Config::getInstance();

return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'migration_base_class' => '\Joeriabbo\OrmMigrationsStandalone\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => $config->getDataBaseDriver(),
            'host' => $config->getDataBaseHost(),
            'name' => $config->getDataBaseName(),
            'user' => $config->getDataBaseUser(),
            'pass' => $config->getDataBasePassword(),
            'port' => $config->getDataBasePort()
        ]
    ]
];