<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Company;
use App\Http\Requests\CommentRequest;

class CommentApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Http\Requests\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company, CommentRequest $request)
    {
        $comment = Comment::create($request->validated() + [
		    'user_id' => auth()->id(),
		    'company_id' => $company->id,
			'author' => auth()->user()->name,
		]);
		
		return response()->view('comment.one',['comment' => $comment],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        return $comment->delete();
    }
}
