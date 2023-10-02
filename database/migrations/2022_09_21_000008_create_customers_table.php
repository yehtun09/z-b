<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket_no')->nullable();
            $table->string('customer_code')->nullable();
            // $table->string('service_plan')->nullable();
            $table->string('bandwidth')->nullable();
            $table->date('register_date')->nullable();//add nullable
            $table->string('sales_voucher_no')->nullable();//add nullable
            $table->string('name')->nullable();//add nullable for site_late & site long require
            $table->string('contact_person')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('address')->nullable();//add nullable for site_late & site long require
            // $table->longText('township');
            // $table->string('service_type')->nullable();
            $table->string('site_lat')->nullable();
            $table->string('site_long')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
