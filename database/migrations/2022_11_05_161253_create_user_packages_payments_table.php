<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPackagePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_packages_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_package_id')->nullable();
            $table->enum('type', ['cc', 'other'])->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('deliveries')->nullable();
            $table->double('amount', 8, 2)->default('0.00');
            $table->date('payment_date');
            $table->longText('description')->nullable();
            $table->string('transection_id')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('user_packages_payments');
    }
}
