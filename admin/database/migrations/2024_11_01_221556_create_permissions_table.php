<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('feature'); // The feature name (e.g., 'accessSettings', 'accessReports')
            $table->unsignedBigInteger('group_id'); // The ID of the user group allowed to access
            $table->timestamps();

            $table->index(['feature', 'group_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
