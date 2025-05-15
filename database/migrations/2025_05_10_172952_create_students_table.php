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
        if(!Schema::hasTable('students')){
            Schema::create('students', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('class_id')->constrained('class')->onDelete('set null')->nullable();
                $table->foreignId('teacher_id')->constrained('teachers')->onDelete('set null')->nullable();

                $table->string('admission_number')->unique();
                $table->string('index_number')->unique()->nullable();

                $table->integer('assignments_received')->default(0);
                $table->integer('assignments_downloaded')->default(0);
                $table->integer('assignments_submitted')->default(0);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
