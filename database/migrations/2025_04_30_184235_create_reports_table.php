<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Who created the report
        $table->unsignedBigInteger('specialist_id')->nullable(); // Who handles it
        $table->string('title');
        $table->text('description');
        $table->string('status')->default('pending'); // pending, accepted, completed
        $table->json('images')->nullable(); // or create a separate ReportImage model
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('specialist_id')->references('id')->on('users')->onDelete('set null');
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
