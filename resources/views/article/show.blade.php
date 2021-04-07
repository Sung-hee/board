@extends('layouts.app')
@section('content')
  <div class="container">
    <h1>{{ $article->title }}</h1>
    <small class="small text-muted">{{ $article->updated_at }}</small>
    <div class="mt-3 pt-3 border-top">{{ $article->content }}</div>
    <div>
      <form action="{{ route('article.destroy', $article->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <a href="{{ route('article.index') }}"><button type="button" class="btn btn-primary">이전</button></a>
        <a href="{{ route('article.edit', $article->id) }}"><button type="button" class="btn btn-warning">수정</button></a>
        <button type="submit" class="btn btn-danger">삭제</button>
      </form>
    </div>
  </div>
@endsection