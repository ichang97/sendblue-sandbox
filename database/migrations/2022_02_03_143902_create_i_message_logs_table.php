<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIMessageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_message_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_status', ['success', 'error']);
            $table->string('from');
            $table->string('to')->nullalbe();
            $table->string('message_status');
            $table->longText('ref_no')->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_message')->nullable();
            $table->longText('remark');
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
        Schema::dropIfExists('i_message_logs');
    }
}
