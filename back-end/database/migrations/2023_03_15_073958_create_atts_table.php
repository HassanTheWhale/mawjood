<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atts', function (Blueprint $table) {
            $table->id();
            $table->integer('qr');
            $table->integer('face')->default(0);
            $table->integer('voice')->default(0);
            $table->integer('geoCheck')->default(0);
            $table->string('geo')->nullable();
            $table->string('note')->nullable();
            $table->string('done')->default(0);
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('event_id')->unsigned();
            $table->unsignedBigInteger('instance_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('instance_id')->references('id')->on('event_instances')->onDelete('cascade');
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
        Schema::dropIfExists('atts');
    }
};