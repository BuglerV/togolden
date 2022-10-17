<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Company;

/**
 * @group user
 * @group company
 */
class CompanyUserTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * @test
     */
    public function user_can_view_companies_page()
    {
		$user = User::factory()->create();
		
        $response = $this->actingAs($user)->get(route('company.index'));

        $response->assertOk();
    }
	
    /**
     * @test
     */
    public function user_can_view_one_company_page()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		
        $response = $this->actingAs($user)->get(route('company.show',$company));

        $response->assertOk();
    }
	
    /**
     * @test
     */
    public function user_can_create_company()
    {
		$user = User::factory()->create();
		$company = Company::factory()->make();
		
        $response = $this->actingAs($user)->postJson(route('company.store',$company->toArray()));

        $response->assertCreated();
		$this->assertDatabaseHas('companies',['title' => $company->title]);
    }
	
    /**
     * @test
     */
    public function user_can_delete_company()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		
        $response = $this->actingAs($user)->deleteJson(route('company.destroy',$company));

        $response->assertOk();
		$this->assertModelMissing($company);
    }
}
