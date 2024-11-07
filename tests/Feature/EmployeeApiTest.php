<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_employee()
    {
        Company::factory()->count(2)->create();
        Employee::factory()->count(5)->create();
        $response = $this->getJson('/api/employees');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'first_name',
                    'second_name',
                    'email',
                    'phone',
                    'company_id',
                ],
            ]);
    }

    public function test_index_empty_employee_table_should_return_empty_array()
    {
        $response = $this->getJson('/api/employees');

        $response->assertStatus(200)
            ->assertExactJson([]);
    }

    public function test_show_employee()
    {
        Company::factory()->create();
        $employee = Employee::factory()->create();
        $response = $this->getJson("/api/employees/{$employee->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'second_name' => $employee->second_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'company_id' => $employee->company_id,
            ]);
    }

    public function test_show_employee_not_found()
    {
        $response = $this->getJson('/api/employees/1');

        $response->assertStatus(404);
    }

    public function test_store_employee()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make();

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(201)
            ->assertJsonFragment([
                'first_name' => $employee->first_name,
                'second_name' => $employee->second_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'company_id' => $employee->company_id,
            ]);
    }

    public function test_store_employee_with_invalid_email_format()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['email' => 'invalid-email']);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_store_employee_with_missing_first_name()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['first_name' => '']);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('first_name');
    }

    public function test_store_employee_with_missing_second_name()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['second_name' => '']);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('second_name');
    }

    public function test_store_employee_with_invalid_email()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['email' => 'invalid-email']);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_store_employee_with_duplicate_email()
    {
        Company::factory()->create();
        $existingEmployee = Employee::factory()->create();
        $employee = Employee::factory()->make(['email' => $existingEmployee->email]);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_store_employee_with_invalid_phone()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['phone' => 'invalid-phone']);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('phone');
    }

    public function test_store_employee_with_duplicate_phone()
    {
        Company::factory()->create();
        $existingEmployee = Employee::factory()->create();
        $employee = Employee::factory()->make(['phone' => $existingEmployee->phone]);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('phone');
    }

    public function test_store_employee_with_invalid_company_id()
    {
        Company::factory()->create();
        $employee = Employee::factory()->make(['company_id' => 999]);

        $response = $this->postJson('/api/employees', $employee->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('company_id');
    }

    public function test_update_employee()
    {
        Company::factory()->create();
        $employee = Employee::factory()->create();
        $newEmployee = Employee::factory()->make(['name' => 'Updated Employee Name']);

        $response = $this->putJson("/api/employees/{$employee->id}", $newEmployee->toArray());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => $newEmployee->first_name,
                'second_name' => $newEmployee->second_name,
                'email' => $newEmployee->email,
                'phone' => $newEmployee->phone,
                'company_id' => $newEmployee->company_id,
            ]);
    }

    public function test_update_employee_not_found()
    {
        Company::factory()->create();
        $newEmployee = Employee::factory()->make(['name' => 'Updated Employee Name']);

        $response = $this->putJson('/api/employees/1', $newEmployee->toArray());

        $response->assertStatus(404);
    }

    public function test_delete_employee()
    {
        Company::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertStatus(204);
    }

    public function test_delete_employee_not_found()
    {
        $response = $this->deleteJson('/api/employees/1');

        $response->assertStatus(404);
    }
}
