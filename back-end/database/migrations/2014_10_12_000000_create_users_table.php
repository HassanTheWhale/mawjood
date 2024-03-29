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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('picture')->default("https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg");
            $table->string('bio')->nullable()->default("");
            $table->string('username')->unique();
            $table->integer('type')->default(0); //private or public account (0 indicates public)
            $table->string('email')->unique();
            $table->integer('verified')->default(0);
            $table->string('vpicture')->nullable();
            $table->string('vaudioA')->nullable();
            $table->string('vaudioB')->nullable();
            $table->string('vaudioC')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};