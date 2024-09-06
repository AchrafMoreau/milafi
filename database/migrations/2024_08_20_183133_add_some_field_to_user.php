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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('city');
            $table->string('name_in_arab');
            $table->enum('gender', ['Male', "Female"]);
            $table->string('city_in_arab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //

            $table->dropColumn(['city', 'name_in_arab', 'gender', 'city_in_arab']);
        });
    }
};
