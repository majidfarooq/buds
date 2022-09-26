<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->nullable();
            $table->unsignedInteger('role_id')->default(null)->nullable();
            $table->string('phone')->unique();
            $table->string('phone_alt')->nullable();
            $table->string('business_name');
            $table->string('email');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->longText('notes')->nullable();
            $table->string('billing_coordinates');
            $table->string('billing_address1');
            $table->string('billing_address2')->nullable();
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_zip');
            $table->string('delivery_coordinates');
            $table->string('delivery_address1');
            $table->string('delivery_address2')->nullable();
            $table->string('delivery_city');
            $table->string('delivery_state');
            $table->string('delivery_zip');
            $table->tinyInteger('deactivated')->default(0)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
