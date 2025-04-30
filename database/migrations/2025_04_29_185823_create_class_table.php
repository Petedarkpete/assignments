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
        if(!Schema::hasTable('class')){
            Schema::create('class', function (Blueprint $table) {
                $table->id();
                $table->string('class_name')->unique();
                $table->unsignedBigInteger('teacher')->nullable();
                $table->foreign('teacher')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedInteger('no_of_students')->nullable()->default(null);
                $table->unsignedInteger('total_assignments_created')->nullable()->default(null);
                $table->unsignedInteger('total_assignments_submited')->nullable()->default(null);
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class');
    }
};
