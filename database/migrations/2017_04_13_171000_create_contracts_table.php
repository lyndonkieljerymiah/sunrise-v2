<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->timestamps();

            $table->string('contract_no',50)->unique();
            
            $table->string('contract_type',20);
            
            $table->date('period_start')->nullable();
            
            $table->date('period_end')->nullable();
            
            $table->decimal('amount')->default(0);
            
            $table->boolean('is_active')->default(1);

            $table->integer('villa_id')->unsigned()->unsigned();

            $table->integer('tenant_id')->unique()->unsigned();

            $table->integer('user_id')->unique();

            $table->string('status',10)->index();

        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
