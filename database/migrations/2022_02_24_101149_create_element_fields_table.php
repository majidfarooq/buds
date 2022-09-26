<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('element_fields', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->enum('type',['attachment','textarea','text','select'])->default(null)->nullable();
            $table->string('value',255)->nullable();
            $table->unsignedInteger('element_id')->default(0)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('element_fields');
    }
}
