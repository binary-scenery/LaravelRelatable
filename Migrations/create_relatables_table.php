<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('relatables', function (Blueprint $table) {

            $table->increments('id');

            // make the row easily deletable
            $table->string('guid');

            # the parent thing

            // parent id for eloquent joining
            $table->integer('parent_id');
            // make the row findable
            $table->integer('parent_guid');
            // the target scope
            $table->string('parent_type');


            # the thing being attached to the parent

            // the child id for eloquent joining
            $table->string('child_id');
            // make the row findable
            $table->string('child_guid');
            // the table scope
            $table->string('child_type');

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
        Schema::dropIfExists('related');
    }
}
