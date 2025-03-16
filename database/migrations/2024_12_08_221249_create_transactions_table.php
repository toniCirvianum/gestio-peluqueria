<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['reservation', 'product-sale', 'mixed']);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->dateTime('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total_price', 10,2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
