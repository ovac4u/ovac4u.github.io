<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            /**
             * This will be the Model Class that
             * is related to this activity.
             */
            $table->string('trackable_type');
            /**
             * This will be the unique id
             * of the trackable model
             */
            $table->integer('trackable_id');
            /**
             * The User ID this activity should
             * relate to.
             */
            $table->integer('user_id');
            /**
             * This will describe the activity
             * that took place. Should be
             * recorded in markdown.
             */
            $table->text('description');
            /**
             * Title of the activity
             */
            $table->text('title');
            /**
             * Type
             */
            $table->text('type');
            /**
             * Timestamps as we know them.
             */
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
        Schema::dropIfExists('activities');
    }
}
