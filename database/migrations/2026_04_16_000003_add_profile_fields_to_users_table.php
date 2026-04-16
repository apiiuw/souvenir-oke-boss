<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('role');
            $table->text('address_line')->nullable()->after('phone');
            $table->string('province_id')->nullable()->after('address_line');
            $table->string('province_name')->nullable()->after('province_id');
            $table->string('city_id')->nullable()->after('province_name');
            $table->string('city_name')->nullable()->after('city_id');
            $table->string('district_id')->nullable()->after('city_name');
            $table->string('district_name')->nullable()->after('district_id');
            $table->string('subdistrict_id')->nullable()->after('district_name');
            $table->string('subdistrict_name')->nullable()->after('subdistrict_id');
            $table->string('rt', 10)->nullable()->after('subdistrict_name');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->text('maps_link')->nullable()->after('rw');
            $table->decimal('maps_latitude', 10, 7)->nullable()->after('maps_link');
            $table->decimal('maps_longitude', 10, 7)->nullable()->after('maps_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address_line',
                'province_id',
                'province_name',
                'city_id',
                'city_name',
                'district_id',
                'district_name',
                'subdistrict_id',
                'subdistrict_name',
                'rt',
                'rw',
                'maps_link',
                'maps_latitude',
                'maps_longitude',
            ]);
        });
    }
};
