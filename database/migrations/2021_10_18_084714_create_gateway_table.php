<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway', function (Blueprint $table) {
            $table->id();
            $table->string('API_NAME');
            $table->string('API_URL');
            $table->string('API_METHOD');
            $table->string('API_TOKEN'); // For Validation of Api
            $table->text('API_DETAILS'); // Array containing DESCRIPTION, API STATUS as well as any other info
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
        Schema::dropIfExists('gateway');
    }
}
