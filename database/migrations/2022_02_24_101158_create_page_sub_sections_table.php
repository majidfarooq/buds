<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSubSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('page_sub_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('row_width')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('page_sub_sections');
    }
}
