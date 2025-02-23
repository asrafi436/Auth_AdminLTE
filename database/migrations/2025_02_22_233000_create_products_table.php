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
        $table->string('name'); // Product Name
        $table->string('category'); // Product Category
        $table->decimal('price', 10, 2); // Product Price
        $table->text('short_description')->nullable(); // Short Description
        $table->longText('long_description')->nullable(); // Long Description
        $table->string('image')->nullable(); // Image Path
        $table->integer('stock')->default(0); // Stock Quantity
        $table->enum('status', ['active', 'inactive'])->default('active'); // Product Status
        $table->string('seo_tags')->nullable(); // SEO Tags
        $table->timestamps(); // Created & Updated Timestamps
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
