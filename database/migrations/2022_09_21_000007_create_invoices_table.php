<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        // site_informations
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('odb_no')->nullable();
            $table->string('odb_lat')->nullable();
            $table->string('odb_long')->nullable();
            $table->string('odb_splitter_no')->nullable();
            $table->string('odb_splitter_pair_no')->nullable();
            $table->string('ont_received_power')->nullable();
            $table->string('olt_name')->nullable();
            $table->date('assign_date')->nullable();
            $table->date('finished_date')->nullable();
            $table->date('suspend_date')->nullable();
            $table->string('assign_team')->nullable();
            $table->string('installation_period')->nullable();
            $table->string('resolution')->nullable();
            $table->integer('start_meter')->default(0);
            $table->integer('end_meter')->default(0);
            $table->integer('drop_cable_length')->default(0);
            $table->integer('cable_drum_no')->default(0);
            $table->integer('drop_sleeve_pcs')->default(0);
            $table->integer('core_jc_sleeve_holder_pcs')->default(0);
            $table->string('patch_cord')->nullable(); // (SC/UPC-SC/UPC-3M), (SC/UPC-SC/UPC-1M), (SC/UPC-SC/APC-3M), (SC/UPC-SC/APC-1M)
            $table->string('cable_tiles_pcs')->nullable();
            $table->string('label_tape_rol')->nullable();
            $table->string('onu_sticker')->nullable();
            $table->string('customer_acceptance_form')->nullable();
            $table->date('issue_date');
            $table->integer('customer_assign')->nullable();
            $table->string('invoice_status')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('received_total_amount')->nullable();
            $table->date('received_date')->nullable();
            $table->longText('remark')->nullable();
            $table->longText('sale_person_remark')->nullable();
            $table->longText('installation_remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}