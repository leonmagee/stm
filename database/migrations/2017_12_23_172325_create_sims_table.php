<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sims', function (Blueprint $table) {
            //$table->increments('id');
            //$table->string('sim_number', 30)->unique();
            $table->string('sim_number', 30);
            $table->integer('value');
            $table->string('activation_date', 15);
            $table->string('mobile_number', 20);
            $table->integer('report_type_id'); // link with other table?
            $table->string('upload_date'); // might need to do a table of dates?
            $table->primary(['sim_number', 'upload_date']);
            // we will query by report type id when outputting sims on a sim page or just
            // tabulating what to pay agents... 
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
        Schema::dropIfExists('sims');
    }
}
