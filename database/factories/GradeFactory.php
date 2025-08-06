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
        ];
    }

    private function getGradeValueForType(string $type): ?string
    {
        switch ($type) {
            case 'numeric':
                return (string) rand(0, 100);
            case 'pass_fail':
                return rand(0, 1) ? 'Pass' : 'Fail';
            case 'letter':
                return collect(['A', 'B', 'C', 'D', 'F'])->random();
            default:
                return null;
        }
    }
}
