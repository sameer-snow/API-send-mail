<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSendQueueEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_send_queue_emails', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('email_send_queue_id')->unsigned();
            $table->foreign('email_send_queue_id')->references('id')->on('email_send_queues')->onDelete('cascade');
            $table->string('email');
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
        Schema::dropIfExists('email_send_queue_emails');
    }
}
