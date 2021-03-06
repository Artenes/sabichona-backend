<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->uuid('uuid')->primary();
            $table->string('location_uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('location_uuid')->references('uuid')->on('location')->onUpdate('cascade')->onDelete('cascade');

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
}
