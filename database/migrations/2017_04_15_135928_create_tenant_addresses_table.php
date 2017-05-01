<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_addresses', function (Blueprint $table) {
            
            $table->integer('tenant_id')->unsigned();

            $table->string('address_1');

            $table->string('address_2');

            $table->string('city');

            $table->string('postal_code');

            

            //foreign key
            $table->foreign('tenant_id')

                ->references('id')

                ->on('tenants');

                

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_addresses');
    }
}
