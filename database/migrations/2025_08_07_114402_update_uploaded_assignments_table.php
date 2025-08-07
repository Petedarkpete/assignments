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
        //
        if(!Schema::hasColumn('uploaded_assignments','confirmed')){
            Schema::table('uploaded_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('confirmed')->nullable();
            });
        }
        if(!Schema::hasColumn('uploaded_assignments','confirmation_at')){
            Schema::table('uploaded_assignments', function (Blueprint $table) {
                $table->timestamp('confirmation_at')->nullable();
            });
        }
        if(!Schema::hasColumn('uploaded_assignments','confirmation_by')){
            Schema::table('uploaded_assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('confirmation_by')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('uploaded_assignments', function (Blueprint $table) {
            if(Schema::hasColumn('uploaded_assignments','confirmed')){
                $table->dropColumn('confirmed');
            }
            if(Schema::hasColumn('uploaded_assignments','confirmation_at')){
                $table->dropColumn('confirmation_at');
            }
            if(Schema::hasColumn('uploaded_assignments','confirmation_by')){
                $table->dropColumn('confirmation_by');
            }
        });
    }
};
