<?php
declare(strict_types=1);

use \Joeriabbo\OrmMigrationsStandalone\Migration\Migration;

final class AddExampleTable extends Migration
{
    public function up(): void
    {
        $this->schema->create('example', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->integer('serial_number');
            $table->string('name');
            $table->timestamps();
        });
    }
}
