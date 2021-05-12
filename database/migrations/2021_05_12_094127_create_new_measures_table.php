<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_measures', function (Blueprint $table) {
            $table->id();
            $table->string('clientName');
            $table->string('clientPhone');
            $table->string('customType');
            $table->integer('shoulderHeight');
            $table->integer('armHeight');
            $table->integer('sides');
            $table->integer('goba');
            $table->string('buttonsType');
            $table->string('kafaType');
            $table->string('pantsType');
            $table->integer('amount');
            $table->integer('price');
            $table->string('paymentMethod');
            $table->integer('paid');
            $table->integer('rest');
            $table->string('dateOfRecive');
            $table->integer('receiptNumber')->unique();
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
        Schema::dropIfExists('new_measures');
    }
}
