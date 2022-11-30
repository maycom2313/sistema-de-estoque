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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            //$table->integer('produto_id')->unsigned();
            $table->foreignId('produto_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 50)->nullable();
            $table->string('size')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('prici',5,2)->nullable();
            $table->string('sexo',50)->nullable();
            $table->string('image')->nullable();
            $table->integer('vendidos')->nullable();
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
        Schema::dropIfExists('vendas');
    }
};
