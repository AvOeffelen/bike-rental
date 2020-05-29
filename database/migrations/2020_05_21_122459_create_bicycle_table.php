<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBicycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicycle', function (Blueprint $table) {
            $table->id();
            $table->string('framenumber');
            $table->tinyInteger('available')->default(0);
            $table->tinyInteger('in_repair')->default(0);
            $table->tinyInteger('requested_repair')->default(0);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')
                ->references('id')->on('location');
            $table->timestamp('lease_start')->nullable();
            $table->timestamp('lease_end')->nullable();
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
        Schema::dropIfExists('bicycle');
    }
}
