<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->string("fullname");
            $table->string("phone");
            $table->string("region");
            $table->string("city");
            $table->string("area");
            $table->string("address");
            $table->boolean("is_default")->default(0);
            $table->enum("status", ["office", "home"])->nullable();
            $table->enum("type", ["shipping_address", "billing_address"]);
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
        Schema::dropIfExists('addresses');
    }
}
