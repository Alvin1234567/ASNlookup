<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apnics', function(Blueprint $table){
            $table->increments('id');
            $table->char('registry',10);
            $table->char('country',10);
            $table->char('type',10);
            $table->char('data',30);
            $table->integer('amount');
            $table->integer('registered_date');
            $table->char('status',50);
            $table->timestamps('');
            });

        Schema::table('apnics', function (Blueprint $table) {
            $table->index('conutry');
            $table->index('type');
            $table->index('registered_date');
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
