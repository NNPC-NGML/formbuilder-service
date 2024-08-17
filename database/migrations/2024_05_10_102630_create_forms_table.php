<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_builders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment("This column would hold the name of the form builder created");
            $table->text('json_form')->comment("This column would hold the json representation of the form");
            $table->unsignedBigInteger('process_flow_id')->nullable()->comment("This column would hold the processflow id, which can comes from processflow service or from automator service");
            $table->unsignedBigInteger('process_flow_step_id')->nullable()->comment("This column would hold the process flow step id");
            $table->unsignedBigInteger('tag_id')->comment("this holds tag id that tags, a form to a particular functionality");
            $table->boolean('status')->default(1)->comment("this column holds the status which could either be 1 active or 0 none active");
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
        Schema::dropIfExists('form_builders');
    }
}
