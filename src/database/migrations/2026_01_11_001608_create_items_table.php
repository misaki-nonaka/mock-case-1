<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_img');
            $table->string('item_name');
            $table->string('brand')->nullable();
            $table->integer('price');
            $table->text('detail');
            $table->tinyInteger('condition');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('sold');
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
        Schema::dropIfExists('items');
    }
}
