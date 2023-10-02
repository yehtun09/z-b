<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('onu_type');
            $table->string('onu_model_no');
            $table->string('ont_serial_no');
            $table->string('onu');
            $table->string('drum_no')->nullable();
            $table->string('patch_cord')->nullable();
            $table->string('drop_sleeve')->nullable();
            $table->string('sleeve_holder')->nullable();
            $table->string('product_name');
            $table->decimal('price', 15, 2);
            $table->string('stock_qty');
            $table->string('total_stock_qty')->default(0);
            $table->string('discount')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('status')->nullable()->comment('inventory type in or out');
            $table->integer('site_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
