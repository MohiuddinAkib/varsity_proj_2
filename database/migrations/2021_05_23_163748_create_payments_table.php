<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("worker_id")->constrained("users")->cascadeOnDelete();
            $table->enum("payment_status", ["paid", "unpaid"]);
            $table->timestamp("payment_date")->nullable();
            $table->unsignedInteger("payment_cut")->default(0);
            $table->unsignedInteger("payment_bonus")->default(0);
            $table->mediumText("payment_bonus_reason")->nullable();
            $table->mediumText("payment_cut_reason")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
