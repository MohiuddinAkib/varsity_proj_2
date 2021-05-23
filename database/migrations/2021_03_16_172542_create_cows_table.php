<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->mediumText("extras");
            $table->mediumText("description");
            $table->dateTime("dob");
            $table->foreignId("farm_id")->constrained()->cascadeOnDelete();
            $table->foreignId("breed_id")->constrained()->nullOnDelete();
            $table->unsignedInteger("gender");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cows');
    }
}
