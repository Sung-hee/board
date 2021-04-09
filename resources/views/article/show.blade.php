@extends('layouts.app')
@section('content')
  <div class="container">
    <h1>{{ $article->title }}</h1>
    <small class="small text-muted">{{ $article->updated_at }}</small>
    @if (!empty($article->image_name) && !empty($article->image_path))
      <div class="form-group">
        <label for="title">이미지</label>
        <img src="{{ asset('storage/images/'. $article->image_name) }}" alt="{{ asset('images/'. $article->image_name) }}" style="width: 100%; height: 100%;">
      </div>
    @endif
    <div class="mt-3 pt-3 border-top">{{ $article->content }}</div>
    <div>
      <form action="{{ route('article.destroy', $article->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <a href="{{ route('article.index') }}"><button type="button" class="btn btn-primary">이전</button></a>
        @if ($article->user_id == auth()->user()->id) 
          <a href="{{ route('article.edit', $article->id) }}"><button type="button" class="btn btn-warning">수정</button></a>
          <button type="submit" class="btn btn-danger">삭제</button>
        @endif
      </form>
    </div>
    <div class="mt-3 border border-dark p-3">
    @foreach($comment as $item)
      <div>
        <div class="mb-2 border border-secondary px-3 pt-2 bg-white">
          <p class="mb-0 font-bold">{{ $item->comment }}</p>
          <p class="font-weight">{{ $item->user_name }} <small class="text-secondary">{{ $item->created_at }}</small></p>
        </div>
      </div>
    @endforeach
    </div>

    @if(session('comment_message'))
    <div class="mt-3">
      <span class="alert alert-success" role="alert">
        <strong>{{ session('comment_message') }}</strong>
      </span>
    </div>
    @endif
    <div class="mt-3">
      <form action="{{ route('comment.add') }}" method="POST">
        @csrf
          <input type="hidden" name="article_id" value="{{ $article->id }}">
          <textarea class="form-control resize-none" name="comment" cols="10" rows="3" style="resize: none;"></textarea>
          <button type="submit" class="btn btn-success mt-3">등록</button>
      </form>
    </div>
  </div>
@endsection