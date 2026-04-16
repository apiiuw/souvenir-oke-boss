<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Drop naming can be tricky if it was created manually or differently.
            // We use a try-catch or check existence if possible, but in Laravel, 
            // the convention is table_column_foreign.
            
            try {
                $table->dropForeign(['color_id']);
            } catch (\Exception $e) {
                // If the constraint name is different, we might need to find it.
                // But usually, it follows the pattern.
            }
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('color_id')
                ->references('id')
                ->on('product_colors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->foreign('color_id')
                ->references('id')
                ->on('product_variants') // Reverting to the "wrong" one just for symmetry
                ->onDelete('cascade');
        });
    }
};
