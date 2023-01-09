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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->reference('id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            //$table->foreignId('sexo_id')->reference('id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 50);
            $table->string('category', 50);
            $table->string('size'); 
            $table->integer('quantity')->nullable();
            $table->decimal('prici',5,2);
            $table->string('sexo',50);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('produtos');
    }
};
