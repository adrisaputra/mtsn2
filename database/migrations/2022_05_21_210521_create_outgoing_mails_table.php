<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_mails', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('mail_number')->nullable();
            $table->date('letter_date')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('sender')->nullable();
            $table->string('address')->nullable();
            $table->string('destination')->nullable();
            $table->text('about')->nullable();
            $table->string('file')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('outgoing_mails');
    }
}
