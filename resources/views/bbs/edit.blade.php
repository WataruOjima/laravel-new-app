@extends('layouts.bbslayout')
 
@section('title', 'LaravelPjt BBS 投稿編集ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿編集ページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')
 
@section('content')
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">
            投稿の編集
        </h1>
        <form method="POST" action="{{ route('bbs.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
 
            <fieldset class="mb-4">
                <div class="form-group">
                    <label for="subject">
                        件名
                    </label>
                    <input
                        id="subject"
                        name="subject"
                        class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        value="{{ old('subject') ?: $post->subject }}"
                        type="text"
                    >
                    @if ($errors->has('subject'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subject') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="message">
                        メッセージ
                    </label>
 
                    <textarea
                        id="message"
                        name="message"
                        class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"
                        rows="4"
                    >{{ old('message') ?: $post->message }}</textarea>
                    @if ($errors->has('message'))
                        <div class="invalid-feedback">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="image1">
                        画像
                    </label>
                    <input
                        class="form-control {{ $errors->has('image_file') ? 'is-invalid' : '' }}"
                        type="file" id="image" name="image_file" accept="image/png, image/jpeg"
                    >
                    @if ($errors->has('image_file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image_file') }}
                        </div>
                    @endif
                </div>
 
                <div class="mt-5">
                    <a class="btn btn-secondary" href="{{ route('bbs.show', $post->id) }}">
                        キャンセル
                    </a>
 
                    <button type="submit" class="btn btn-primary">
                        編集する
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection
 
@include('layouts.bbsfooter')