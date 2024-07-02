<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiStudentTest extends TestCase
{
    use RefreshDatabase;

    private string $baseApi = "api/students/";


    public function testStudentShow(): void
    {
        $student = Student::factory()->create();
        $studentData = $student->only(['name', 'email', 'group']);

        $response = $this->getJson($this->baseApi . $student->id);

        $response->assertStatus(200)
            ->assertJsonFragment($studentData);
    }

    public function testStudentStore(): void
    {
        $data = [
            'name' => 'Boris Borisov',
            'email' => 'boris@example.ru'
        ];

        $response = $this->postJson($this->baseApi, $data);

        $response->assertStatus(200)->assertJsonPath('success', true);
    }

    public function testStudentUpdate(): void
    {
        $student = Student::factory()->create();

        $newData = [
            'name' => 'Ivan Ivanov',
            'email' => 'edited@email.foo'
        ];

        $response = $this->patchJson($this->baseApi . $student->id, $newData);

        $response->assertOk();

        /** @var Student $editedStudent */
        $editedStudent = Student::find($student->id);
        $editedData = $editedStudent->only(['name', 'email']);

        $this->assertEquals($newData, $editedData);
    }

    public function testStudentDestroy()
    {
        $student = Student::factory()->create();

        $response = $this->deleteJson($this->baseApi . $student->id);

        $response->assertOk();
        $this->assertNull(Student::find($student->id));
    }
}
