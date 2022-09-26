<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageElementsTable extends Migration
{
  public function up()
  {
    Schema::create('page_elements', function (Blueprint $table) {
      $table->id();
      $table->enum('type', ['header', 'footer', 'content'])->default('content')->nullable();
      $table->unsignedInteger('page_id')->default(0)->nullable();
      $table->unsignedInteger('element_id')->default(0)->nullable();
      $table->integer('position')->nullable();
      $table->string('e_id')->nullable();
      $table->string('e_class')->nullable();
      $table->string('children_ids')->nullable();
      $table->integer('page_section_id')->nullable();
      $table->integer('sub_section_id')->nullable();
      $table->integer('order')->nullable();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('page_elements');
  }
}
