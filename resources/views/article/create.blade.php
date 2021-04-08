@extends('layouts.app')
@section('content')
  <div class="container">
    <form action="{{ route('article.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="title">제목</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="" aria-describedby="title" value="{{ old('title') }}">
        @error('title')
        <p class="invalid-feedback">제목을 입력하세요</p>
        @enderror
      </div>
      <div class="form-group">
        <label for="content">내용</label>
        <textarea class="form-control @error('content') is-invalid  @enderror" name="content" id="content" rows="3">{{ old('content') }}</textarea>
        @error('content')
        <p class="invalid-feedback">내용을 입력하세요</p>
        @enderror
      </div>
      <div class="form-group">
        <label for="image">이미지</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="">
      </div>
      <button type="submit" class="btn btn-primary">저장</button>
    </form>
  </div>
@endsection