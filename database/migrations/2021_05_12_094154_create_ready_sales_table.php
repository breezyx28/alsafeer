<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_sales', function (Blueprint $table) {
            $table->id();
            $table->string('clientName');
            $table->string('customType');
            $table->integer('amount');
            $table->integer('price');
            $table->string('paymentMethod');
            $table->string('shiftUser');
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
        Schema::dropIfExists('ready_sales');
    }
}
