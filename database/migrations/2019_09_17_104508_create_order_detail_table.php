<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('name')->nullable();
            $table->enum("type", ["material", "exclusive"]);
            $table->double('price',13,4)->default(0);
            $table->integer('menu_id')->unsigned()->nullable();
            $table->string('menu_name')->nullable();
            $table->enum("menu_type", ["spicy", "soft"]);
            $table->integer('quantity')->default(0);
            $table->double('total_amount', 10, 4)->nullable();
            $table->text('remark')->nullable();
            $table->enum('status',['order', 'pending', 'confirm', 'delivered','cancel']);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->date('delivered_at')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
