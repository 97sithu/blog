@extends("layouts.app")

@section("content")
	<div class="container">
		@if(session('error'))
		<div class="alert alert-danger">
			{{session('error')}}
		</div>
		@endif
			<div class="card mb-4">
				<div class="card-body">
					<h5 class="card-title">{{$article->title}}</h5>
					<div class="card-subtitle mb-2 text-muted small">
						{{$article->created_at->diffForHumans()}},
						User:<b>{{$article->user->name}}</b>
						Category:<b>{{$article->category['name']}}</b>
					</div>
					
				
					<p class="card-text">{{$article->body}}</p>
					<a 
					href="{{url("/articles/delete/$article->id")}}"
					class="btn btn-danger float-right">
						Delete
					</a>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item active">
					Comments<span class="badge badge-light">
						{{count($article->comments)}}
					</span>
					</li>
					@foreach($article->comments as $comment)
					<li class="list-group-item">
						<input type="hidden" name="user_id" value="{{$article->user->id}}">
						<a href="{{url("/comments/delete/$comment->id")}}" class="close">
						&times;
					</a>
					<div class="small mt-2">
						By <b>{{$comment->user->name}}</b>,
						{{$comment->created_at->diffForHumans() }}
					</div>
					{{$comment->content}}
					 </li>
				
				@endforeach
			</ul>
			@auth
			<form action="{{url('/comments/add')}}" method="post">
				@csrf
				<input type="hidden" name="article_id" value="{{$article->id}}">
				<input type="hidden" name="user_id" value="{{$article->user->id}}">
				<textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
				<input type="submit" value="Add Comment" class="btn btn-secondary">
			</form>
			@endauth
	</div>
	@endsection