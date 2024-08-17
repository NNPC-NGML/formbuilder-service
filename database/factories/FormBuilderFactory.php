<?php

namespace Database\Factories;

use App\Models\FormBuilder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormBuilder>
 */
class FormBuilderFactory extends Factory
{
    protected $model = FormBuilder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'json_form' => json_encode([
                'field1' => $this->faker->word,
                'field2' => $this->faker->word,
            ]),
            "process_flow_id" => $this->faker->numberBetween(0, 100),
            "process_flow_step_id" => $this->faker->numberBetween(0, 100),
            "tag_id" => $this->faker->numberBetween(0, 100),


        ];
    }
}
