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
            $table->integer('shoulderHeight')->nullable()->default(0);
            $table->integer('armHeight')->nullable()->default(0);
            $table->integer('sides')->nullable()->default(0);
            $table->integer('goba')->nullable()->default(0);
            $table->string('buttonsType')->nullable()->default(0);
            $table->string('kafaType')->nullable()->default(0);
            $table->string('pantsType')->nullable()->default(0);
            $table->integer('amount');
            $table->integer('price');
            $table->string('paymentMethod');
            $table->integer('paid');
            $table->integer('rest')->nullable()->default(0);
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
