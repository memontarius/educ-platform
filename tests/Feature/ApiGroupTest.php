<?php

namespace Tests\Feature;


use App\Models\Group;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ApiGroupTest extends TestCase
{
    use RefreshDatabase;

    private string $baseApi = "api/classes/";


    public function testGroupDestroy(): void
    {
        $group = Group::factory()->create();
        $student = Student::factory()->create();

        $this->assertEquals($student->group_id, $group->id);

        $response = $this->deleteJson($this->baseApi . $group->id);

        $response->assertOk()->assertJsonPath('success', true);

        $student->refresh();
        $this->assertNull($student->group_id);
    }
}
