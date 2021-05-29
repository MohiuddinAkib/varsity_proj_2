<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMarkedForSaleColumnAndIsSoldColumnOnCowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->boolean("is_marked_for_sale")->default(0)->after("dob");
            $table->boolean("is_sold")->default(0)->after("is_marked_for_sale");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropColumn(["is_sold"]);
            $table->dropColumn(["is_marked_for_sale"]);
        });
    }
}
