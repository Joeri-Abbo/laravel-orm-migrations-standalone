<?php
declare(strict_types=1);

use \Joeriabbo\OrmMigrationsStandalone\Migration\Migration;

final class MyFirstMigration extends Migration
{
    public function up(): void
    {
        $this->schema->create('widgets', function(Illuminate\Database\Schema\Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            $table->integer('serial_number');
            $table->string('name');
            // Required for Eloquent's created_at and updated_at columns
            $table->timestamps();
        });
    }
}
