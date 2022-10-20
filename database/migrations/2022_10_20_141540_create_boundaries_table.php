<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoundariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boundaries', function (Blueprint $table) {
            $table->id();
            $table->string('boundary_uid')->index()->unique();
            $table->string('name')->index();
            $table->integer('level')->unsigned();
            $table->string('country_uid')->index()->unique();
            $table->timestamps();

            $table->unique(['country_uid', 'name']);
            $table->unique(['country_uid', 'level']);
            $table->foreign('country_uid')->references('country_uid')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boundaries');
    }
}
