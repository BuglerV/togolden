<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Company;
use App\Models\Comment;

/**
 * @group user
 * @group comment
 */
class CommentUserTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * @test
     */
    public function user_can_comment_company()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		
		$text = 'Some comment!!!';
		
        $response = $this->actingAs($user)->postJson(route('comment.store',$company),[
		    'text' => $text,
			'field' => 'null',
			'author' => $user->name,
		]);

        $response->assertCreated();
		
		$this->assertDatabaseHas('comments',['text' => $text]);
    }
	
    /**
     * @test
     */
    public function user_can_comment_field()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		
		$text = 'Some comment!!!';
		
        $response = $this->actingAs($user)->postJson(route('comment.store',$company),[
		    'text' => $text,
			'field' => 'description',
			'author' => $user->name,
		]);

        $response->assertCreated();
		
		$this->assertDatabaseHas('comments',['text' => $text, 'field' => 'description']);
    }
	
    /**
     * @test
     */
    public function user_can_delete_comment()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		$comment = Comment::create([
		    'user_id' => $user->id,
			'company_id' => $company->id,
			'field' => 'null',
			'author' => $user->name,
			'text' => 'Some comment!!!',
		]);

        $response = $this->actingAs($user)->deleteJson(route('comment.destroy',$comment));

        $response->assertOk();
		
		$this->assertModelMissing($comment);
    }
}
