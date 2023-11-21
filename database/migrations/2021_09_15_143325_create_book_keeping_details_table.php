<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookKeepingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_keeping_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_keeping_header_id')->nullable();
            $table->unsignedBigInteger('gold_id');
            $table->timestamps();
            $table->integer('quantity');
            $table->boolean('isAddition');
            $table->index('book_keeping_header_id');
            $table->foreign('book_keeping_header_id')->references('id')->on('book_keeping_headers')->onDelete('cascade');
            $table->index('gold_id');
            $table->foreign('gold_id')->references('id')->on('gold')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_keeping_details');
    }
}
