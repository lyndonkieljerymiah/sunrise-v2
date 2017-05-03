<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_terminations', function (Blueprint $table) {
            
            $table->increments('id');

            $table->timestamps();
            
            $table->integer('contract_id')->unsigned()->index();

            $table->text('description');

            $table->string('ref_no');

             //foreign key
            $table->foreign('contract_id')

                ->references('id')

                ->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_terminations');
    }
}