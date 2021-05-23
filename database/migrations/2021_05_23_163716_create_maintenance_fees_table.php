<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId("farm_id")->constrained()->cascadeOnDelete();
            $table->mediumText("reason");
            $table->unsignedInteger("expense_amount");
            $table->timestamp("date_of_incident");
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
        Schema::dropIfExists('maintenance_fees');
    }
}
