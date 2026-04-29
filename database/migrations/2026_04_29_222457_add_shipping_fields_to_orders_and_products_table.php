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
            $table->integer('weight')->default(200)->after('price'); // default 200 grams (water bottle estimate)
        });


        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_cost')->default(0)->after('total_price');
            $table->string('courier')->nullable()->after('shipping_cost');
            $table->string('service')->nullable()->after('courier');
            $table->integer('total_weight')->default(0)->after('total_qty');
            $table->unsignedBigInteger('grand_total')->default(0)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('weight');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'courier', 'service', 'total_weight', 'grand_total']);
        });
    }
};
