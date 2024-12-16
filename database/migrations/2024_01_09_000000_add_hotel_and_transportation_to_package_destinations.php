<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('package_destinations', function (Blueprint $table) {
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->onDelete('set null');
            $table->foreignId('transportation_id')->nullable()->constrained('transportations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('package_destinations', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['transportation_id']);
            $table->dropColumn(['hotel_id', 'transportation_id']);
        });
    }
};
