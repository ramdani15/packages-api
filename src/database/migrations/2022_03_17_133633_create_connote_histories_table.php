<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnoteHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connote_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connote_id');
            $table->string('name');
            $table->text('description');
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });

        Schema::table('connote_histories', function (Blueprint $table) {
            $table->index('connote_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connote_histories');
    }
}
