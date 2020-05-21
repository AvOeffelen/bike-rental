<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BicycleHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicycle_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bicycle_id');
            $table->foreign('bicycle_id')
                ->references('id')->on('bicycle');
            $table->string('title', 255);
            $table->text('description');
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
        Schema::dropIfExists('bicycle_history');
    }
}
