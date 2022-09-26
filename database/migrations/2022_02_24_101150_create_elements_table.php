<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementsTable extends Migration
{
  public function up()
  {
    Schema::create('elements', function (Blueprint $table) {
      $table->id();
      $table->string('title', 255)->nullable();
      $table->enum('type',['parent','daughter'])->nullable();
      $table->unsignedInteger('parentId')->nullable();
      $table->longText('template')->nullable();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('elements');
  }
}
