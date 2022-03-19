<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('state_id');
            $table->string('amount');
            $table->string('discount');
            $table->string('additional_field')->nullable();
            $table->string('code');
            $table->integer('order');
            $table->decimal('cash_amount', 11, 2)->default(0);
            $table->decimal('cash_change', 11, 2)->default(0);
            $table->json('custome_fields')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('payment_type_id');
            $table->index('state_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
