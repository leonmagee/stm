<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTypeSiteValues extends Migration
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
            $table->integer('plan_value');
            $table->integer('payment_amount');
            $table->integer('report_type_site_defaults_id')->nullable();
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
