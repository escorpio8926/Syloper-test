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
    /*
 id: int(11) auto_increment NOT NULL
 titulo: varchar(100)
 slug*: varchar(100)
 imagen: varchar(100)
 descripcion: text
 created: datetime
 modified: datetime
    */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->string('slug',100);
            $table->string('imagen',100);
            $table->text('descripcion');
            $table->timestamps();
            //foreing key
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); 
            //foreing key
            $table->unsignedBigInteger('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories'); 
        });
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
