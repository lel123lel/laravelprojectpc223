<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->string('reference_id', 9)->after('id')->unique();
        });
    }

    public function down()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn('reference_id');
        });
    }
};
