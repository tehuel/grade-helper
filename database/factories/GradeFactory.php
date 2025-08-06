<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assessment;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradeType = $this->faker->randomElement(['numeric', 'pass_fail', 'letter']);
        $gradeValue = $this->getGradeValueForType($gradeType);
        return [
            'type' => $gradeType,
            'value' => $gradeValue,
            'assessment_id' => Assessment::factory(),
            'student_id' => User::factory(),
            'comment' => $this->faker->sentence,
        ];
    }

    public function numeric(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'numeric',
                'value' => $this->getGradeValueForType('numeric'),
            ];
        });
    }

    public function pass_fail(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'pass_fail',
                'value' => $this->getGradeValueForType('pass_fail'),
            ];
        });
    }

    public function letter(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'letter',
                'value' => $this->getGradeValueForType('letter'),
            ];
        });
    }

    private function getGradeValueForType(string $type): ?string
    {
        switch ($type) {
            case 'numeric':
                return (string) $this->faker->numberBetween(0, 100);
            case 'pass_fail':
                return $this->faker->boolean() ? 'Pass' : 'Fail';
            case 'letter':
                return $this->faker->randomElement(['A', 'B', 'C', 'D', 'F']);
            default:
                return null;
        }
    }
}
