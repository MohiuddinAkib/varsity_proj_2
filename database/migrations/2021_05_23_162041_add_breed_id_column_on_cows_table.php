<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreedIdColumnOnCowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->foreignId("breed_id")->after("farm_id")->constrained()->nullOnDelete();
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
            $table->dropForeign(["breed_id"]);
        });
    }
}
