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
            $table->string('name')->comment("This column would hold the name of the form builder created");;
            $table->text('field_structure')->comment("This column would hold the json of the form builder fields");
            $table->unsignedBigInteger('process_flow_id')->nullable()->comment("This column would hold the processflow id, which can comes from processflow service or from automator service");
            $table->unsignedBigInteger('tag_id')->nullable()->comment("This column would hold the tag id");
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
