<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCustomerAssignsTable extends Migration
{
    public function up()
    {
        Schema::table('customer_assigns', function (Blueprint $table) {
            $table->unsignedBigInteger('service_person_id')->nullable();
            $table->foreign('service_person_id', 'service_person_fk_7298542')->references('id')->on('users');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_7298547')->references('id')->on('users');
        });
    }
}
