<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_header_id');
            $table->unsignedBigInteger('gold_id');
            $table->integer('quantity');
            $table->integer('price');

            $table->index('transaction_header_id');
            $table->foreign('transaction_header_id')->references('id')->on('transaction_headers')->onDelete('cascade');
            $table->index('gold_id');
            $table->foreign('gold_id')->references('id')->on('gold')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_details');
    }
}
