<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('session_id')->nullable()->index();
            $table->string('customer_name');
            $table->string('recipient_name');
            $table->string('phone', 30);
            $table->text('address_line');
            $table->string('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->string('city_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('district_id')->nullable();
            $table->string('district_name');
            $table->string('subdistrict_id')->nullable();
            $table->string('subdistrict_name');
            $table->string('rt', 10);
            $table->string('rw', 10);
            $table->text('maps_link')->nullable();
            $table->decimal('maps_latitude', 10, 7)->nullable();
            $table->decimal('maps_longitude', 10, 7)->nullable();
            $table->text('delivery_note')->nullable();
            $table->unsignedInteger('total_qty');
            $table->unsignedBigInteger('total_price');
            $table->string('whatsapp_number', 30);
            $table->longText('whatsapp_message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
