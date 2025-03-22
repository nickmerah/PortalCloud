<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User who made the change
            $table->string('action'); // Action taken (e.g., created, updated, deleted)
            $table->string('table_name'); // Name of the table being modified
            $table->unsignedBigInteger('record_id')->nullable(); // ID of the record modified
            $table->json('old_data')->nullable(); // JSON data of old values (before change)
            $table->json('new_data')->nullable(); // JSON data of new values (after change)
            $table->timestamps();

            $table->index(['table_name', 'record_id']); // Optional: Index for fast lookup
        });
    }

    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
