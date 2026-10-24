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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('book'); // book, digital_pdf, consultation
            $table->string('title');
            $table->string('title_ml')->nullable();
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('image_path')->nullable();
            $table->string('badge')->nullable();
            $table->json('details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('shipping_address')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_title');
            $table->string('product_type')->default('book');
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('INR');
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable()->index();
            $table->string('razorpay_signature')->nullable();
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('delivery_status')->default('pending'); // pending, delivered, shipped
            $table->json('birth_details')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
