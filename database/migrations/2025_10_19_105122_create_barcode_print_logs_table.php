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
        Schema::create('barcode_print_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('product_code', 50);
            $table->string('product_name');
            $table->decimal('product_price', 25, 4);
            $table->integer('copies_printed')->default(1);
            $table->timestamp('printed_at');
            $table->string('printed_by')->nullable();
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('product_code');
            $table->index('printed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_print_logs');
    }
};
