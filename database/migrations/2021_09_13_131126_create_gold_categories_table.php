<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoldCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gold_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gold_id');
            $table->unsignedBigInteger('category_id');

            $table->index('gold_id');
            $table->foreign('gold_id')->references('id')->on('gold')->onDelete('cascade');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('gold_categories');
    }
}
