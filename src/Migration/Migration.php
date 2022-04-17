<?php

namespace Joeriabbo\OrmMigrationsStandalone\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;
use Joeriabbo\OrmMigrationsStandalone\Core\Config;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var Capsule $capsule */
    public Capsule $capsule;
    /** @var Builder $capsule */
    public Builder $schema;
    private Config $config;

    public function init()
    {
        $this->config = Config::getInstance();
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => $this->config->getDataBaseHost(),
            'port' => $this->config->getDataBasePort(),
            'database' => $this->config->getDataBaseName(),
            'username' => $this->config->getDataBaseName(),
            'password' => $this->config->getDataBasePassword(),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}