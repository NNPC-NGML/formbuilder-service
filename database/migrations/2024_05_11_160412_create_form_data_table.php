<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataTable extends Migration
{
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_builder_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('form_field_answers')->nullable();
            $table->integer('automator_task_id');
            $table->integer('process_flow_history_id');
            $table->string('entity');
            $table->integer('entity_id');
            $table->integer('entity_site_id')->nullable();
            $table->integer('user_id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_data');
    }
}
