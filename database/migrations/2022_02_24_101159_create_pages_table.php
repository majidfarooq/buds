<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
  public function up()
  {
    Schema::create('pages', function (Blueprint $table) {
      $table->id();
      $table->string('title', 255)->nullable();
      $table->string('slug', 255)->nullable();
      $table->tinyInteger('is_home')->default(0)->nullable();
      $table->enum('page_type', ['simple', 'fullpage'])->default('simple')->nullable();
      $table->string('meta_title', 255)->nullable();
      $table->longText('meta_keywords')->nullable();
      $table->longText('meta_description')->nullable();
      $table->string('banner')->nullable();
      $table->longText('banner_content')->nullable();
      $table->longText('page_css')->nullable();
      $table->longText('page_script')->nullable();
      $table->tinyInteger('is_disabled')->default(0)->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('pages');
  }
}
