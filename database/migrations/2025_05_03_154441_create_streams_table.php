<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('streams')){
            Schema::create('streams', function (Blueprint $table) {
                $table->id();
                $table->string('stream');
                $table->unsignedBigInteger('teacher_id');
                $table->timestamps();

                $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};
