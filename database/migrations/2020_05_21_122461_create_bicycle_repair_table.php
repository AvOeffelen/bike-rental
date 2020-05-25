<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBicycleRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicycle_repair', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bicycle_id');
            $table->foreign('bicycle_id')
                ->references('id')->on('bicycle');
            $table->text('description');
            $table->tinyInteger('granted')->default(0);
            $table->tinyInteger('is_finished')->default(0);
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('bicycle_repair');
    }
}
