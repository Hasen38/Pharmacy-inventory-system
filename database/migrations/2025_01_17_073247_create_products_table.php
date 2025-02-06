<?php

use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('description')->nullable();
            $table->integer('stock')->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('dosage');
            $table->string('brand');
            $table->foreignId('category_id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->cascadeOnDelete();
            $table->timestamps();
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
