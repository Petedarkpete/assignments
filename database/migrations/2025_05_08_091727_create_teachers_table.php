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
        if (!Schema::hasTable('teachers')){
            Schema::create('teachers', function (Blueprint $table) {

                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedBigInteger("class_assigned")->nullable();
                $table->foreign("class_assigned")->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');

                $table->string('qualification')->nullable();
                $table->string('specialization')->nullable();
                $table->date('join_date');

                $table->unsignedInteger('no_of_subjects')->nullable();
                $table->unsignedInteger('no_of_assignments')->nullable();
                $table->unsignedInteger('no_of_classes_teaching')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
