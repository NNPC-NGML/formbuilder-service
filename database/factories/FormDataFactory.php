<?php

namespace Database\Factories;

use App\Models\FormData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormBuilder>
 */
class FormDataFactory extends Factory
{
    protected $model = FormData::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'form_builder_id' => $this->faker->numberBetween(1, 100),
            'form_field_answers' => json_encode([
                'field1' => $this->faker->word,
                'field2' => $this->faker->word,
            ]),
            'automator_task_id' => $this->faker->numberBetween(1, 100),
            'process_flow_history_id' => $this->faker->numberBetween(1, 100),
            'entity' => "customer",
            'entity_id' => $this->faker->numberBetween(1, 100),
            'entity_site_id' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 100),
            'status' => 0,
        ];
    }
}
