<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlackToSpreadsheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_to_spreadsheet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slack_channels_id')->constrained('slack_channels');
            $table->foreignId('spreadsheets_id')->constrained('spreadsheets');
            $table->string('key_word');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->unique(['slack_channels_id', 'spreadsheets_id', 'key_word'], 'slack_to_spreadsheet_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slack_to_spreadsheet');
    }
}
