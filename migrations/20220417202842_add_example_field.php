<?php
declare(strict_types=1);

use \Joeriabbo\OrmMigrationsStandalone\Migration\Migration;

final class AddExampleField extends Migration
{
    public function up(): void
    {
        $this->schema->table('example', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('some_field')->after('id');
        });
    }
}
