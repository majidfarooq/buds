<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->foreignId('role_id')->constrained();
            $table->enum('type',['user','vendor'])->nullable();
            $table->string('provider_id')->nullable();
            $table->string('image', 255)->default('dummy.jpg')->nullable();
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('zipcode', 255)->nullable();
            $table->string('billing_address1', 255)->nullable();
            $table->string('billing_address2', 255)->nullable();
            $table->string('billing_city', 255)->nullable();
            $table->string('billing_state', 255)->nullable();
            $table->string('billing_country', 255)->nullable();
            $table->string('billing_zipcode', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->text('interests')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
