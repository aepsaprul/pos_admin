<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryProductInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_product_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->double('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('sub_total')->nullable();
            $table->dateTimeTz('date')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('inventory_product_ins');
    }
}
