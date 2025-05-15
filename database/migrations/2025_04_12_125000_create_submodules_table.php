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
        Schema::create('submodules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the submodule
            $table->string('slug')->unique(); // Slug for URL routing
            $table->string('icon')->nullable(); // Optional icon (e.g., "bi-file-earmark")
            $table->string('url')->nullable(); // Optional URL for redirection
            $table->unsignedBigInteger('module_id'); // Foreign key referencing the module
            $table->integer('order')->default(0); // Order of appearance in the submodule menu
            $table->boolean('status')->default(1); // Active or inactive status (1=active, 0=inactive)
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint for the module
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submodules');
    }
};

