<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Наименование');
            $table->string('description', 500)->nullable()->comment('Описание');
            $table->float('price', 10, 2)->comment('Цена');
            $table->string('image', 500)->nullable()->comment('Изображение');
            $table->boolean('is_published')->default(false)->comment('Статус публикации');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
