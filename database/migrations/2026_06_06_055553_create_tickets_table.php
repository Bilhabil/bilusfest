<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_detail_id')->constrained('order_details')->cascadeOnDelete();
            $table->string('ticket_number')->unique();
            $table->enum('status', ['valid', 'used', 'cancelled'])->default('valid');
            $table->timestamps();

            $table->index(['ticket_number', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
