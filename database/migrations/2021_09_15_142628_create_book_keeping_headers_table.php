<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookKeepingHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_keeping_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shelf_id');
            $table->double('scale_weight', 8, 2);
            $table->double('calculation_weight', 8, 2);
            $table->dateTime('from_date');
            $table->dateTime('to_date');

            $table->timestamps();
            $table->index('shelf_id');
            $table->foreign('shelf_id')->references('id')->on('shelves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_keeping_headers');
    }
}
