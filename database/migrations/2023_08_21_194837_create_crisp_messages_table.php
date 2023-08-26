<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrispMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crisp_messages', function (Blueprint $table) {
            $table->id();
            $table->string('website_id');
            $table->string('fingerprint')->index();
            $table->string('session_id')->index();
            $table->string('name')->index();
            $table->string('from');
            $table->text('content')->nullable();
            $table->json('user');
            $table->boolean('stamped');
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
        Schema::dropIfExists('crisp_messages');
    }
}