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
            'field_structure' => [
                [
                    'fieldId' => 'field1',
                    'name' => $this->faker->word,
                    'label' => $this->faker->sentence,
                    'inputType' => $this->faker->randomElement(['text', 'number', 'email']),
                    'required' => $this->faker->boolean,
                    'placeholder' => $this->faker->sentence
                ]
            ],
            'access_control' => [
                [
                    'user' => $this->faker->numberBetween(1, 100),
                    'role' => $this->faker->randomElement(['viewer', 'editor']),
                ],
                [
                    'user' => $this->faker->numberBetween(101, 200),
                    'role' => $this->faker->randomElement(['viewer', 'editor']),
                ]
            ]
        ];
    }
}
