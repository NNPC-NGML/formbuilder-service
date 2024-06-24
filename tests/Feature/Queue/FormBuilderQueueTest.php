<?php

namespace Tests\Feature\Queue;

use App\Jobs\Formbuilder\FormBuilderCreated;
use App\Models\FormBuilder;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;


class FormBuilderQueueTest extends TestCase
{


    use RefreshDatabase;

    public function test_it_dispatches_form_builder_created_job()
    {
        Queue::fake();

        $form_builder = FormBuilder::factory()->create();

        FormBuilderCreated::dispatch($form_builder->toArray());

        Queue::assertPushed(FormBuilderCreated::class, function ($job) use ($form_builder) {
            return $job->getData() == $form_builder->toArray();
        });
    }
}
