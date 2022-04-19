<?php

namespace Joeriabbo\OrmMigrationsStandalone\Core;

use PDO;

class Export
{
    private PDO $pdo;

    /**
     * Export constructor.
     */
    public function __construct()
    {
        $this->setUp();
    }

    /**
     * Setup
     * @return void
     */
    private function setUp(): void
    {
        $config = Config::getInstance();
        $host = $config->getDataBaseHost();
        $db = $config->getDataBaseName();;
        $user = $config->getDataBaseUser();
        $pass = $config->getDataBasePassword();
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * @return void
     */
    public function generate(): void
    {
        $tables = $this->getTables();
        $this->generateMigration($tables);
    }

    /**
     * Get tables from database
     * @return array
     */
    private function getTables(): array
    {
        $tables = [];
        $query_tables = $this->pdo->query('SHOW TABLES');

        while ($row = $query_tables->fetch()) {
            foreach ($row as $table) {
                $tables[] = $table;
            }
        }

        foreach ($this->blackListedTables() as $table) {
            if (in_array($table, $tables)) {
                unset($tables[array_search($table, $tables)]);
            }
        }
        return $tables;
    }

    /**
     * Blacklisted tables
     * @return string[]
     */
    public function blackListedTables(): array
    {
        return [
            'phinxlog'
        ];
    }

    /**
     * Generate the migration file
     * @param array $tables
     * @return void
     */
    private function generateMigration(array $tables): void
    {
        if (empty($tables)) {
            return;
        }
        array_map('unlink', glob(__DIR__ . "/../../dumps/*.sql"));

        foreach ($tables as $table) {
            $this->generateMigrationForTable($table);
        }
    }

    /**
     * Generate a migration for a table
     * @param mixed $table
     * @return void
     */
    private function generateMigrationForTable(mixed $table): void
    {
        $data = $this->pdo->query('SHOW CREATE TABLE ' . $table)->fetch();
        if (empty($data) || empty($data['Create Table'])) {
            return;
        }
        file_put_contents('dumps/' . $table . '.sql', $data['Create Table']);
    }
}