<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->string('name')->after('reference_id');
            $table->string('student_id')->after('name');
        });
    }

    public function down()
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn(['name', 'student_id']);
        });
    }
};
