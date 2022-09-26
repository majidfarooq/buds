<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('sub_section_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('e_id')->nullable();
            $table->string('e_class')->nullable();
            $table->enum('container_type',['container-fluid','container'])->default('container-fluid')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('page_sections');
    }
}
