<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_company()
    {
        Company::factory()->count(5)->create();
        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'address',
                    'city',
                    'postal_code',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_index_empty_company_table_should_return_empty_array()
    {
        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertExactJson([]);
    }

    public function test_show_company()
    {
        $company = Company::factory()->create();
        $response = $this->getJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $company->id,
                'name' => $company->name,
                'nip' => $company->nip,
                'address' => $company->address,
                'city' => $company->city,
                'postal_code' => $company->postal_code,
                'created_at' => $company->created_at,
                'updated_at' => $company->updated_at,
            ]);
    }

    public function test_show_company_not_found()
    {
        $response = $this->getJson('/api/companies/1');

        $response->assertStatus(404);
    }

    public function test_store_company()
    {
        $company = Company::factory()->make();

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $company->name,
                'nip' => $company->nip,
                'address' => $company->address,
                'city' => $company->city,
                'postal_code' => $company->postal_code,
            ]);
    }

    public function test_store_company_with_nip_wrong_format()
    {
        // NIP too long
        $company = Company::factory()->make();
        $company->nip = str_repeat('1', 11);

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nip');

        // NIP too short
        $company = Company::factory()->make();
        $company->nip = str_repeat('1', 9);

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nip');

        // NIP contains non-numeric characters
        $company = Company::factory()->make();
        $company->nip = str_repeat('1', 9).'A';

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nip');
    }

    public function test_store_company_with_postal_code_wrong_format()
    {
        // Postal code without dash
        $company = Company::factory()->make();
        $company->postal_code = '12345';

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('postal_code');

        // Postal code with letter
        $company = Company::factory()->make();
        $company->postal_code = '1234a';

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('postal_code');

        // Postal code with too short
        $company = Company::factory()->make();
        $company->postal_code = '1234';

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('postal_code');

        // Postal code with too long
        $company = Company::factory()->make();
        $company->postal_code = '123456';

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors('postal_code');
    }

    public function test_update_company()
    {
        $company = Company::factory()->create();
        $newCompany = Company::factory()->make();
        $newCompany->name = 'New Company Name';

        $response = $this->putJson("/api/companies/{$company->id}", $newCompany->toArray());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $newCompany->name,
                'nip' => $newCompany->nip,
                'address' => $newCompany->address,
                'city' => $newCompany->city,
                'postal_code' => $newCompany->postal_code,
            ]);
    }

    public function test_update_company_not_found()
    {
        $newCompany = Company::factory()->make();
        $newCompany->name = 'New Company Name';

        $response = $this->putJson('/api/companies/1', $newCompany->toArray());

        $response->assertStatus(404);
    }

    public function test_delete_company()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson("/api/companies/{$company->id}");

        $response->assertStatus(204);
    }

    public function test_delete_company_not_found()
    {
        $response = $this->deleteJson('/api/companies/1');

        $response->assertStatus(404);
    }
}
