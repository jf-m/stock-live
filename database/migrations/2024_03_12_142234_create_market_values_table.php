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
        Schema::create('market_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained();
            $table->decimal('open', 10, 4);
            $table->decimal('high', 10, 4);
            $table->decimal('low', 10, 4);
            $table->decimal('close', 10, 4);
            $table->integer('volume')->unsigned();
            $table->timestamp('interval_time');
            $table->unique(['stock_id', 'interval_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_values');
    }
};
