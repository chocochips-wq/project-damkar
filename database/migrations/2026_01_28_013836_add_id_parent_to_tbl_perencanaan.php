<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_perencanaan', function (Blueprint $table) {
            $table->string('id_parent', 10)->nullable()->after('id_perencanaan');
        });
    }

    public function down()
    {
        Schema::table('tbl_perencanaan', function (Blueprint $table) {
            $table->dropColumn('id_parent');
        });
    }
};
