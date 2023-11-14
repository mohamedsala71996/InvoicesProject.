<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number',50)->Unique();
            $table->date('invoice_Date');
            $table->date('due_date'); //تاريخ استحقاق
            $table->string('product');
            $table->unsignedBigInteger('sections_id');
            $table->foreign('sections_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('Amount_collection',8,2)->nullable();;
            $table->decimal('Amount_Commission',8,2);
            $table->decimal('discount');
            $table->string('tax_rate'); //نسبة
            $table->decimal('tax_value',8,2); //قيمة الضريبة
            $table->decimal('Total',8,2);
            $table->string('Status', 50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->string('created_by');
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
