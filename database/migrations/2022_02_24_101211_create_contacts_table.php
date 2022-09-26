<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->string('email');
            $table->string('subject', 255)->nullable();
            $table->longText('message')->nullable();
            $table->enum('status',['pending','replied','awarded'])->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
