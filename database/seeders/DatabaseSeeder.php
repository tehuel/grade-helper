<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $initialTeacher = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $teachers = User::factory(3)->create()->push($initialTeacher);
        $students = User::factory(10)->create();
        $courses = Course::Factory(5)->create();
        
        foreach ($courses as $course) {
            $selectedTeachers = $teachers->random(2);
            $course->teachers()->attach($selectedTeachers->pluck('id')->toArray());

            $selectedStudents = $students->random(rand(1, 5));
            $course->students()->attach($selectedStudents->pluck('id')->toArray());

            // Create assessments for each course
            $courseAssessments = Assessment::factory(rand(2, 4))
                ->for($course)
                ->create();

            foreach ($courseAssessments as $assessment) {
                $gradingType = $assessment->grading_type;
                $gradingValue = $this->getGradingValueForType($gradingType);

                // create grades for some students
                Grade::factory(rand(0, 3))
                    ->for($assessment)
                    ->for($selectedStudents->random(), 'student')
                    ->create([
                        'type' => $gradingType,
                        'value' => $gradingValue,
                    ]);
            }
        }
    }

    private function getGradingValueForType(string $type): ?string
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
