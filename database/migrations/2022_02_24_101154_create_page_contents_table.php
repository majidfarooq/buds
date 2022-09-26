<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageContentsTable extends Migration
{
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('page_element_id')->nullable();
            $table->unsignedInteger('field_id')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('page_contents');
    }
}
