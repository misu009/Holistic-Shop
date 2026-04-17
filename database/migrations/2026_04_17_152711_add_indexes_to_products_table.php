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
        Schema::table('products', function (Blueprint $table) {
            $table->index('price');
        });

        // 2. Index the pivot table for faster category lookups
        // Note: foreignId()->constrained() usually creates an index, 
        // but a composite index here makes "Products in Category" queries lightning fast.
        Schema::table('category_products', function (Blueprint $table) {
            $table->index(['product_category_id', 'product_id'], 'cat_prod_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['price']);
        });

        Schema::table('category_products', function (Blueprint $table) {
            $table->dropIndex('cat_prod_lookup_index');
        });
    }
};
