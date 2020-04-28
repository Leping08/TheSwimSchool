<?php


namespace Tests\Feature;


use App\Lesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorCalendarTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function only_an_admin_can_visit_the_instructor_calendar_page()
    {
        $instructor = factory(User::class)->create();

        $this->get(route('calendar', ['user' => $instructor]))
            ->assertStatus(302);

        $this->actingAs($instructor);

        $this->get(route('calendar', ['user' => $instructor]))
            ->assertStatus(200);
    }

    /** @test  **/
    public function the_calendar_page_shows_lessons_only_for_the_instructor_calendar_being_looked_at()
    {
        $this->seed();

        $instructor_1 = factory(User::class)->create();
        $instructor_2 = factory(User::class)->create();

        $lesson_1 = factory(Lesson::class)->create([
            'instructor_id' => $instructor_1->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3'
        ]);
        $lesson_1->DaysOfTheWeek()->sync(explode(',', $lesson_1->days));

        $lesson_2 = factory(Lesson::class)->create([
            'instructor_id' => $instructor_2->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => "1,3"
        ]);
        $lesson_2->DaysOfTheWeek()->sync(explode(',', $lesson_2->days));

        $this->actingAs($instructor_1);
        $this->get(route('calendar', ['user' => $instructor_1]))
            ->assertStatus(200)
            ->assertSee($lesson_1->group->type)
            ->assertDontSee($lesson_2->group->type);

        $this->actingAs($instructor_2);
        $this->get(route('calendar', ['user' => $instructor_2]))
            ->assertStatus(200)
            ->assertSee($lesson_2->group->type)
            ->assertDontSee($lesson_1->group->type);
    }

    /** @test  **/
    public function the_calendar_will_not_show_lessons_older_then_3_months_ago()
    {
        $this->seed();

        $instructor = factory(User::class)->create();

        $lesson_1 = factory(Lesson::class)->create([
            'instructor_id' => $instructor->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3'
        ]);
        $lesson_1->DaysOfTheWeek()->sync(explode(',', $lesson_1->days));

        $lesson_2 = factory(Lesson::class)->create([
            'instructor_id' => $instructor->id,
            'class_start_date' => Carbon::now()->subMonths(4),
            'class_end_date' => Carbon::now()->subDays(100), //Around 3 months
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3'
        ]);
        $lesson_2->DaysOfTheWeek()->sync(explode(',', $lesson_2->days));

        $this->actingAs($instructor);
        $this->get(route('calendar', ['user' => $instructor]))
            ->assertStatus(200)
            ->assertSee($lesson_1->group->type)
            ->assertDontSee($lesson_2->group->type);
    }
}