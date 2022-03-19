<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kolis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connote_id');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->string('code');
            $table->integer('length')->default(0);
            $table->text('awb_url');
            $table->decimal('chargeable_weight', 11, 2);
            $table->integer('width')->default(0);
            $table->json('surcharge')->nullable();
            $table->integer('height')->default(0);
            $table->text('description');
            $table->decimal('volume', 11, 2)->default(0);
            $table->decimal('weight', 11, 2)->default(0);
            $table->json('custome_fields')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });

        Schema::table('kolis', function (Blueprint $table) {
            $table->index('connote_id');
            $table->index('formula_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kolis');
    }
}
