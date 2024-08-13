<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataTable extends Migration
{
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            //$table->id()->comment("Primary key for the form data table");
            $table->id(); //Primary key for the form data table
            $table->foreignId('form_builder_id')->nullable()->constrained()->onDelete('cascade'); //If a form is deleted, its associated data will also be deleted 
            $table->json('form_field_answers')->nullable(); //JSON field to store answers to the form fields
            $table->integer('automator_task_id'); //ID of the automator task linked to this form data
            $table->integer('process_flow_history_id'); //ID of the process flow history linked to this form data
            $table->string('entity'); //String field to store the entity type related to the form data
            $table->integer('entity_id'); //ID of the specific entity instance
            $table->integer ('entity_site_id')->nullable(); //Optional site ID related to the entity
            $table->integer('user_id'); //ID of the user who submitted the form
            $table->boolean('status')->default(1); //Status field to indicate whether the form data is active or inactive");
            $table->timestamps(); //Timestamps for when the form data record was created and last updated
        });
    }

    public function down()
    {   
        // Drops the form_data table if the migration is rolled back
        Schema::dropIfExists('form_data');
    }
}
