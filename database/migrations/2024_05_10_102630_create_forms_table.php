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
            $table->text('json_form')->comment("This column would hold the Json of the form builder to be rendered on the FE");
            $table->json('field_structure')->comment("This column would hold the json of the form builder fields");
            $table->json('access_control')->comment("This column would hold the user id and access type");
            $table->unsignedBigInteger('process_flow_id')->nullable()->comment("This column would hold the processflow id, which can comes from processflow service or from automator service");
            $table->unsignedBigInteger('automator_flow_id')->nullable()->comment("This column would hold the automator id, which can comes from processflow service or from automator service");
            $table->unsignedBigInteger('task_id')->nullable()->comment("This column would hold the task id");
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
