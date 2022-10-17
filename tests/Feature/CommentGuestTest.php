<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Company;
use App\Models\Comment;

/**
 * @group guest
 * @group comment
 */
class CommentGuestTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * @test
     */
    public function guest_cant_comment_company()
    {
		$company = Company::factory()->create();
		
		$text = 'Some comment!!!';
		
        $response = $this->postJson(route('comment.store',$company),['text' => $text]);

        $response->assertUnauthorized();
		
		$this->assertDatabaseMissing('comments',['text' => $text]);
    }
	
    /**
     * @test
     */
    public function guest_cant_comment_field()
    {
		$company = Company::factory()->create();
		
		$text = 'Some comment!!!';
		
        $response = $this->postJson(route('comment.store',$company),[
		    'text' => $text,
			'field' => 'description',
		]);

        $response->assertUnauthorized();
		
		$this->assertDatabaseMissing('comments',['text' => $text, 'field' => 'description']);
    }
	
    /**
     * @test
     */
    public function guest_cant_delete_comment()
    {
		$user = User::factory()->create();
		$company = Company::factory()->create();
		$comment = Comment::create([
		    'user_id' => $user->id,
			'company_id' => $company->id,
			'author' => $user->name,
			'text' => 'Some comment!!!',
		]);
		
        $response = $this->deleteJson(route('comment.destroy',$company,$comment));

        $response->assertUnauthorized();
		
		$this->assertModelExists($comment);
    }
}
