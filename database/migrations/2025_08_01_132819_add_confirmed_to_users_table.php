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
        if(!Schema::hasColumn('users', 'confirmed')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('added_by')->nullable();
                $table->timestamp('added_at')->nullable();

                $table->boolean('confirmed')->default(false);
                $table->timestamp('confirmed_at')->nullable();
                $table->string('confirmed_by')->nullable();
                //deleted
                $table->boolean('deleted')->default(false);
                $table->timestamp('deleted_at')->nullable();
                $table->string('deleted_by')->nullable();
                //modified
                $table->boolean('modified')->default(false);
                $table->timestamp('modified_at')->nullable();
                $table->string('modified_by')->nullable();
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
            $table->dropColumn(['added_by', 'added_at', 'confirmed', 'confirmed_at', 'confirmed_by', 'deleted', 'deleted_at', 'deleted_by', 'modified', 'modified_at', 'modified_by']);
        });
    }
};
