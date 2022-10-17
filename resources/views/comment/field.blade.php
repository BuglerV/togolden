  @if(isset($company->comments[$field]))
	  @foreach($company->comments[$field] as $comment)
		  @include('comment.one',['comment' => $comment])
	  @endforeach
  @endif