<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('main_id')->nullable();
            $table->integer('sub_id')->nullable();
            $table->char('show', 1)->nullable();
            $table->char('create', 1)->nullable();
            $table->char('edit', 1)->nullable();
            $table->char('delete', 1)->nullable();
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
        Schema::dropIfExists('nav_accesses');
    }
}
