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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string("desc");
            $table->unsignedBigInteger('cas_id');
            $table->foreign('cas_id')->references('id')->on('cas')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount');
            $table->enum('status', ['Paid', 'Unpaid', 'Overdue']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
