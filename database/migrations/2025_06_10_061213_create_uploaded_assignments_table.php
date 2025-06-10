<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\HashTable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('uploaded_assignments')) {
             Schema::create('uploaded_assignments', function (Blueprint $table) {
                $table->id();

                $table->string('title');
                $table->text('description')->nullable();

                $table->string('file_path')->nullable();
                $table->string('external_link')->nullable();

                $table->date('due_date')->nullable();

                $table->unsignedBigInteger('teacher_id');
                $table->unsignedBigInteger('class_id');
                $table->unsignedBigInteger('subject_id');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_assignments');
    }
};
