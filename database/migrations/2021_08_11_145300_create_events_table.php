<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50);
            $table->string('holder', 20);
            $table->date('date');
            $table->time('time');
            $table->string('location', 100);
            $table->integer('help_num');
            $table->integer('attend_num');
            $table->string('content', 500);
        });

        // add MEDIUMBLOB type
        DB::statement("ALTER TABLE events ADD image MEDIUMBLOB");
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
}
