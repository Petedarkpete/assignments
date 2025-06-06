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
                $table->string('label');
                $table->unsignedBigInteger('stream_id');
                $table->foreign('stream_id')->references('id')->on('streams')->onDelete('set null')->onUpdate('cascade');

                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null')->onUpdate('cascade');

                $table->boolean('status');

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
