<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('title');      
            $table->string('fname');      
            $table->string('lname');   
            $table->string('email')->unique(); 
            $table->integer('country');   
            $table->integer('state');  
            $table->integer('city');    
            $table->string('phone')->unique();   
            $table->unsignedBigInteger('troom');   
            $table->unsignedBigInteger('bed'); 
            $table->integer('nroom'); 
            $table->string('meal'); 
            $table->date('cin'); 
            $table->date('cout'); 
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
        
    }
}
