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
    Schema::create('job_progresses', function (Blueprint $table) {
        $table->id();
        $table->string('image_path');  // To store the image path for progress images
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('job_progresses', function (Blueprint $table) {
        
    });

    Schema::dropIfExists('job_progresses');
}

};
