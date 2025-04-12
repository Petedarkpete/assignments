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
        Schema::create('modules', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Display name of the module
            $table->string('slug')->unique(); // Slug for URL routing
            $table->string('icon')->nullable(); // Optional icon (e.g. "bi-house")
            $table->string('url')->nullable(); // Optional URL for redirection
            $table->integer('order')->default(0); // Order of appearance in the menu
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent ID if it's a submodule
            $table->boolean('status')->default(1); // Active or inactive status (1=active, 0=inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
