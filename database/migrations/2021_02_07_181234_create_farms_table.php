<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("location");
            $table->string("contact_number")->nullable();
            $table->foreignId("owner_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("ladmin_id")->nullable()->constrained("users")->nullOnDelete();
            $table->timestamp("establish_date");
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
        Schema::dropIfExists('farms');
    }
}
