<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_bills', function (Blueprint $table) {
            
            $table->increments('id');

            $table->timestamps();

            $table->string('bill_no',50)->index();

            $table->integer('contract_id')->unique()->unsigned();

            $table->integer('user_id')->unique();

            $table->string('status',20)->index();

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
        Schema::dropIfExists('contract_bills');
    }
}
