<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\FormBuilder;
use Tests\TestCase;

class FormBuilderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testGetFormById()
    {
        $form = FormBuilder::create([
            'name' => 'Test Form',
            'json_form' => '{"field": "value"}',
            'field_structure' => json_encode(['field1' => 'value1']),
            'access_control' => [
                ['user' => 'user1', 'role' => 'editor'],
                ['user' => 'user2', 'role' => 'viewer']
            ]
        ]);

        $response = $this->get(route('forms.show', ['id' => $form->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $form->id,
            'name' => $form->name
        ]);
    }

    public function testFormNotFound()
    {
        $nonExistentForId = mt_rand(1000000000, 9999999999);

        $response = $this->get(route('forms.show', ['id' => $nonExistentForId]));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Form not found']);
    }
}
