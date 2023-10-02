<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->foreign('service_type_id', 'service_type_id_fk_7299708')->references('id')->on('service_types')->onDelete('cascade');
            $table->unsignedBigInteger('service_plan_id')->nullable();
            $table->foreign('service_plan_id', 'service_plan_id_fk_7299708')->references('id')->on('service_plans')->onDelete('cascade');
            $table->unsignedBigInteger('township_id')->nullable();
            $table->foreign('township_id', 'township_id_fk_7299708')->references('id')->on('townships')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
