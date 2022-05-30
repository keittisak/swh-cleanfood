<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 30)->unique();
            $table->enum('type',['daily', 'course']);
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('total_quantity')->default(0);
            $table->double('total_amount', 10, 4)->nullable();
            $table->double('packing_charge', 10, 4)->nullable();
            $table->double('discount', 10, 4)->nullable();
            $table->double('shipping_fee', 10, 4)->nullable();
            $table->double('net_total_amount', 10, 4)->nullable();
            $table->integer('shipping_zone')->unsigned()->nullable();
            $table->text('shipping_name')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone', 30)->nullable();
            $table->text('transfer_image')->nullable();
            $table->enum('status',['order', 'confirm','cancel']);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('orders');
    }
}
