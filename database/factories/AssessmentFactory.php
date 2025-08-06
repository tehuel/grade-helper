<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradingTypes = ['numeric', 'pass_fail', 'letter'];
        $gradingType = $this->faker->randomElement($gradingTypes);
        return [
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(),
            'grading_type' => $gradingType,

            'course_id' => Course::factory(),
        ];
    }
}
