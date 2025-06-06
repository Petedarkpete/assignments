<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('years', function (Blueprint $table) {
            $table->integer('year')->change(); 
        });
    }

    public function down()
    {
        Schema::table('years', function (Blueprint $table) {
            $table->string('year')->change();
        });
    }

};
