<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoldTable extends Migration
{
    /**
     * Run the migrations.
     *+
     * @return void
     */
    public function up()
    {
        Schema::create('gold', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('gold_carat_category_id');
            $table->unsignedBigInteger('shelf_id');
            $table->string('name');
            $table->string('img_path');
            $table->double('weight', 8, 2);
            $table->timestamps();
            
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('gold_carat_category_id');
            $table->foreign('gold_carat_category_id')->references('id')->on('gold_carat_categories')->onDelete('cascade');
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
        Schema::dropIfExists('gold');
    }
}
