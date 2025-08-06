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
        if(!Schema::hasColumn('users', 'activation_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('activation_token')->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(false);
            });
        }
        if (!Schema::hasColumn('users', 'activation_token_expires_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('activation_token_expires_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
