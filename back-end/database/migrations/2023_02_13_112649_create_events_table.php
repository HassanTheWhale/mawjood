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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('picture')->default("https://source.unsplash.com/1920x1080/?school");
            $table->integer('min_grade')->default(-1);
            $table->integer('type');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time', 0)->format('H:i');
            $table->time('end_time', 0)->format('H:i');
            $table->integer('strange')->default(0);
            $table->integer('closed')->default(0);
            $table->integer('allowSignup')->default(0);
            $table->integer('private')->default(0);
            $table->string('key')->nullable()->unique();
            $table->string('attendKey')->unique();
            $table->string('geo')->nullable();
            $table->integer('geoCheck')->default(0);
            $table->string('attendKey')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category')->unsigned();
            $table->foreign('category')->references('id')->on('event_categories')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
};