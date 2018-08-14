<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportTypeSiteValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_type_site_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('report_type_id');
            $table->integer('spiff_value')->nullable();
            $table->integer('residual_percent')->nullable();
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
        Schema::dropIfExists('report_type_site_values');
    }
}
