<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->json('images')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['waiting', 'completed', 'rejected', 'accepted', 'escalated', 'in_progress'])->default('waiting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Revert back to the original columns
            $table->dropColumn(['user_id', 'title', 'description', 'images', 'latitude', 'longitude', 'status']);
        });
    }
};
