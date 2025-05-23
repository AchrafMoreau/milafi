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
        Schema::table('cas', function (Blueprint $table) {
            //
            $table->string('report_number')->nullable();
            $table->string('execution_number')->nullable();
            $table->string('report_file')->nullable();
            $table->string('execution_file')->nullable();
            $table->string('opponent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cas', function (Blueprint $table) {
            //
            $table->dropColumn(['report_number', 'report_file', 'execution_file', 'opponent' ,'execution_number']);
        });
    }
};
