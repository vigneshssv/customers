<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->integer('customer')->nullable();
            $table->enum('address_type',['shipping','billing'])->nullable();
            $table->string('city')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('state')->nullable();
            $table->integer('pincode')->nullable();
            $table->enum('is_primary', ['yes', 'no'])->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('customer_address');
    }
}
