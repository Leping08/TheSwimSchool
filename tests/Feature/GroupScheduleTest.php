<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupScheduleTest extends TestCase
{
    #[Test]
    public function group_schedule_page_returns_200(): void
    {
        $response = $this->get(route('groups.schedule.index'));

        $response->assertStatus(200);
    }
}
