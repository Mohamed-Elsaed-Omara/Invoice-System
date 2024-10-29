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
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');// تاريخ الاستحقاق
            $table->string('product');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->decimal('amount_collection',8,2);
            $table->decimal('amount_commission',8,2);
            $table->decimal('discount',8,2);
            $table->string('rate_vat');
            $table->decimal('value_vat',8,2);
            $table->decimal('total',8,2);
            $table->tinyInteger('status');
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('user');
            $table->softDeletes();
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
