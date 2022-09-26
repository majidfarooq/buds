<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageElementSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('page_element_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('page_element_sections');
    }
}
