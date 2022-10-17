<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Company;

/**
 * @test
 * @group guest
 * @group company
 */
class CompanyGuestTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * @test
     */
    public function guest_can_view_companies_page()
    {
        $response = $this->get(route('company.index'));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guest_can_view_one_company_page()
    {
		$company = Company::factory()->create();
		
        $response = $this->get(route('company.show',$company));

        $response->assertStatus(200);
    }
	
    /**
     * @test
     */
    public function guest_can_create_company()
    {
		$company = Company::factory()->make();
		
        $response = $this->postJson(route('company.store',$company->toArray()));

        $response->assertUnauthorized();
		$this->assertDatabaseMissing('companies',['title' => $company->title]);
    }
	
    /**
     * @test
     */
    public function guest_can_delete_company()
    {
		$company = Company::factory()->create();
		
        $response = $this->deleteJson(route('company.destroy',$company));

        $response->assertUnauthorized();
		
		$this->assertModelExists($company);
    }
}
