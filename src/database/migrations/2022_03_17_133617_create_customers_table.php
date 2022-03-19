<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('organization_id');
            $table->string('name');
            $table->string('code');
            $table->string('address');
            $table->string('address_detail')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('nama_sales')->nullable();
            $table->string('top')->nullable();
            $table->string('jenis_pelanggan')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('location_id');
            $table->index('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
