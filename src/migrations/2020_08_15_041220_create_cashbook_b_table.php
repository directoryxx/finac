<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbookBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbook_b', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber');
            $table->string('code');
            $table->string('name');
            $table->string('currency');
            $table->decimal('exchangerate',18,5);
            $table->decimal('credit',18,5);
            $table->decimal('debit',18,5);
            $table->text('description');
            $table->foreign('transactionnumber')->references('transactionnumber')->on('cashbooks');
            $table->string('createdby')->nullable();
            $table->dateTime('updateddate')->nullable();
            $table->string('deleteby')->nullable();
            $table->string('updatedby')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('cashbook_bs');
    }
}
