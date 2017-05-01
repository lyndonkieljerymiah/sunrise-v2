<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('selections', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->timestamps();
            
            $table->string('code',50)->unique();
            
            $table->string('name',150);
            
            $table->string('category',50)->index();

            $table->integer('parent')
                ->index()
                ->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
