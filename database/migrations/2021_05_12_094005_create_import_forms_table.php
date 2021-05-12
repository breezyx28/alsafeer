<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('totalPrice')->nullable()->default(0);
            $table->integer('jalabeya')->nullable()->default(0);
            $table->integer('jalabeyaPrice')->nullable()->default(0);
            $table->integer('alaalla')->nullable()->default(0);
            $table->integer('alaallaPrice')->nullable()->default(0);
            $table->integer('pants')->nullable()->default(0);
            $table->integer('pantsPrice')->nullable()->default(0);
            $table->integer('tageeya')->nullable()->default(0);
            $table->integer('tageeyaPrice')->nullable()->default(0);
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
        Schema::dropIfExists('import_forms');
    }
}
