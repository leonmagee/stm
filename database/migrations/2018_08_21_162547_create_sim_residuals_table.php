<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimResidualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('sim_residuals', function (Blueprint $table) {
            $table->string('sim_number', 30);
            $table->integer('value');
            $table->string('activation_date', 15);
            $table->string('mobile_number', 20);
            $table->integer('report_type_id');
            $table->string('upload_date');
            $table->primary(['sim_number', 'upload_date']);
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
        Schema::dropIfExists('sim_residuals');
    }
}
