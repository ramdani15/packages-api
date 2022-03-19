<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('source_tariff_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('order');
            $table->unsignedInteger('number');
            $table->string('service');
            $table->string('code');
            $table->string('booking_code')->nullable();
            $table->decimal('actual_weight', 4, 1)->default(0);
            $table->decimal('volume_weight', 4, 1)->default(0);
            $table->decimal('chargeable_weight', 4, 1)->default(0);
            $table->unsignedInteger('total_package')->default(0);
            $table->unsignedInteger('surcharge_amount')->default(0);
            $table->unsignedInteger('sla_day')->default(0);
            $table->string('pod')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });

        Schema::table('connotes', function (Blueprint $table) {
            $table->index('transaction_id');
            $table->index('source_tariff_id');
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
        Schema::dropIfExists('connotes');
    }
}
