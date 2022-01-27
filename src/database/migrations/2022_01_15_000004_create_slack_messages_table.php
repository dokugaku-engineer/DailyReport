<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlackMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slack_users_id')->constrained('slack_users');
            $table->foreignId('slack_teams_id')->constrained('slack_teams');
            $table->foreignId('slack_channels_id')->constrained('slack_channels');
            $table->text('message');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slack_messages');
    }
}
