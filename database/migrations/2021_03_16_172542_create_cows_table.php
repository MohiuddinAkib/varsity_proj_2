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
            $table->foreignId("farm_id")->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->unsignedInteger("weight");
            $table->enum("type", ["dairy", "fattening"]);
            $table->enum("gender", ["male", "female"]);
            $table->mediumText("description")->nullable();
            $table->timestamp("dob");
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
