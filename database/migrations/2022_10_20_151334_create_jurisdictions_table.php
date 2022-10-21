<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurisdictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurisdictions', function (Blueprint $table) {
            $table->id();
            $table->string('jurisdiction_uid')->index()->unique();
            $table->string('name')->index();
            $table->string('boundary_uid');
            $table->string('parent_uid')->nullable();
            $table->timestamps();

            $table->unique(['name', 'boundary_uid']);
            $table->foreign('boundary_uid')->references('boundary_uid')->on('boundaries')->onDelete('cascade');
        });
        
        Schema::table('jurisdictions', function (Blueprint $table) {
            $table->foreign('parent_uid')->references('jurisdiction_uid')->on('jurisdictions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurisdictions');
    }
}
