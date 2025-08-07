<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

const STUDENTS_COUNT = 10;
const TEACHERS_COUNT = 2;
const COURSES_COUNT = 3;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Teacher::factory()
            ->for(
                User::factory()->create([
                    'email' => 'teacher@example.com',
                ])
            )
            ->create([
                'first_name' => 'Test',
                'last_name' => 'Teacher',
            ]);

        Student::factory()
            ->for(
                User::factory()->create([
                    'email' => 'student@example.com',
                ])
            )
            ->create([
                'first_name' => 'Test',
                'last_name' => 'Student',
                'github_username' => 'tehuel',
            ]);

        Student::factory(STUDENTS_COUNT)->create();
        Teacher::factory(TEACHERS_COUNT)->create();
        Course::factory(COURSES_COUNT)->create();

        $allCourses = Course::all();
        $allTeachers = Teacher::all();
        $allStudents = Student::all();
        $studentGroups = $allStudents->split($allCourses->count());

        foreach ($allCourses as $index => $course) {
            $selectedTeachers = $allTeachers->random(2);
            $selectedStudents = $studentGroups[$index];

            $course->teachers()->attach($selectedTeachers);
            $course->students()->attach($selectedStudents);

            // Create assessments for each course
            $courseAssessments = Assessment::factory(rand(1, 5))
                ->for($course)
                ->create()
                ->each(function ($assessment) use ($selectedStudents) {
                    // create grades for each assessment
                    Grade::factory()
                        ->count(rand(0, 3))
                        ->for($assessment)
                        ->recycle($selectedStudents)
                        ->{$assessment->grading_type}() // Call grading_type state method
                        ->create();
                });

        }
    }
}