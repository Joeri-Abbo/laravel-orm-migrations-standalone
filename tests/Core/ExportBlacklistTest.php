<?php

namespace Joeriabbo\OrmMigrationsStandalone\Tests\Core;

use PHPUnit\Framework\TestCase;

class ExportBlacklistTest extends TestCase
{
    public function testBlacklistedTablesContainsPhinxlog(): void
    {
        // Use a partial mock to avoid the PDO connection in the constructor
        $export = $this->getMockBuilder(\Joeriabbo\OrmMigrationsStandalone\Core\Export::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $this->assertContains('phinxlog', $export->blackListedTables());
    }

    public function testBlacklistedTablesReturnsArray(): void
    {
        $export = $this->getMockBuilder(\Joeriabbo\OrmMigrationsStandalone\Core\Export::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $this->assertIsArray($export->blackListedTables());
    }
}
