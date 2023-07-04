<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_tags', function (Blueprint $table) {
            $table->id()->unique();

            $table->integer('id_user');
            $table->string('name');
            $table->float('longitude', 55, 25); //долгота
            $table->float('latitude', 55, 25);  //широта

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
        Schema::dropIfExists('map_tags');
    }
};
