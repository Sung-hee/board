@extends('layouts.app')
@section('content')
  <div class="container">
  @if(session('message'))
      <span class="alert alert-danger" role="alert">
          <strong>{{ session('message') }}</strong>
      </span>
  @endif
    @foreach($articles as $article)
      <div class="card mb-3">
        <div class="row no-gutters">
          <div class="col-md-3">
            <img src="..." class="card-img" alt="">
          </div>
          <div class="col-md-9">
            <div class="card-body">
              <h5 class="card-title">
                <a href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a>
              </h5>
              <p class="card-text">{{ $article->content }}</p>
              <p class="card-text">
                <small class="text-muted">작성자 : {{ $article->user_name }}</small> | 
                <small class="text-muted">{{ $article->updated_at }}</small>
              </p>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <a href="{{ route('article.create') }}"><button type="type" class="btn btn-primary">글쓰기</button></a>
  </div>
@endsection