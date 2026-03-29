<?php

namespace Joeriabbo\OrmMigrationsStandalone\Tests\Core;

use Joeriabbo\OrmMigrationsStandalone\Core\Config;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset singleton before each test
        $ref = new ReflectionClass(Config::class);
        $prop = $ref->getProperty('instance');
        $prop->setValue(null, null);

        // Clear env vars so defaults are used
        foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_PORT', 'DB_DRIVER'] as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
        }
    }

    public function testGetInstanceReturnsSameInstance(): void
    {
        $a = Config::getInstance();
        $b = Config::getInstance();
        $this->assertSame($a, $b);
    }

    public function testDefaultHost(): void
    {
        $this->assertSame('localhost', Config::getInstance()->getDataBaseHost());
    }

    public function testDefaultName(): void
    {
        $this->assertSame('api', Config::getInstance()->getDataBaseName());
    }

    public function testDefaultUser(): void
    {
        $this->assertSame('root', Config::getInstance()->getDataBaseUser());
    }

    public function testDefaultPassword(): void
    {
        $this->assertSame('root', Config::getInstance()->getDataBasePassword());
    }

    public function testDefaultPort(): void
    {
        $this->assertSame('3306', Config::getInstance()->getDataBasePort());
    }

    public function testDefaultDriver(): void
    {
        $this->assertSame('mysql', Config::getInstance()->getDataBaseDriver());
    }

    public function testEnvOverridesDefaults(): void
    {
        $_ENV['DB_HOST'] = 'db.example.com';
        $_ENV['DB_NAME'] = 'mydb';
        $_ENV['DB_USER'] = 'admin';
        $_ENV['DB_PASSWORD'] = 'secret';
        $_ENV['DB_PORT'] = '5432';
        $_ENV['DB_DRIVER'] = 'pgsql';

        $config = Config::getInstance();
        $this->assertSame('db.example.com', $config->getDataBaseHost());
        $this->assertSame('mydb', $config->getDataBaseName());
        $this->assertSame('admin', $config->getDataBaseUser());
        $this->assertSame('secret', $config->getDataBasePassword());
        $this->assertSame('5432', $config->getDataBasePort());
        $this->assertSame('pgsql', $config->getDataBaseDriver());
    }
}
