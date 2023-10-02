<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAssignsTable extends Migration
{
    public function up()
    {
        // site_assign
        Schema::create('customer_assigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('service_area')->nullable;
            $table->string('township');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
