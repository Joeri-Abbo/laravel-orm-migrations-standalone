<?php

namespace Joeriabbo\OrmMigrationsStandalone\Core;

use Dotenv\Dotenv;

class Config
{
    private static ?Config $instance = null;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
    }

    /**
     * Get instance of Config
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get db Host
     * @return string
     */
    public function getDataBaseHost(): string
    {
        return $_ENV['DB_HOST'] ?? 'localhost';

    }

    /**
     * Get db name
     * @return string
     */
    public function getDataBaseName(): string
    {
        return $_ENV['DB_NAME'] ?? 'api';
    }

    /**
     * Get db user
     * @return string
     */
    public function getDataBaseUser(): string
    {
        return $_ENV['DB_USER'] ?? 'root';

    }

    /**
     * Get db password
     * @return string
     */
    public function getDataBasePassword(): string
    {
        return $_ENV['DB_PASSWORD'] ?? 'root';

    }

    /**
     * Get db password
     * @return string
     */
    public function getDataBasePort(): string
    {
        return $_ENV['DB_PORT'] ?? '3306';
    }
}