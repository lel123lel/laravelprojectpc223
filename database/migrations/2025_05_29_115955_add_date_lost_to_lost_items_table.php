<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateLostToLostItemsTable extends Migration
{
    public function up()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dateTime('date_lost')->nullable()->after('location');
        });
    }

    public function down()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn('date_lost');
        });
    }
}