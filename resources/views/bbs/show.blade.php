@extends('layouts.bbslayout')
 
@section('title', '投稿の一覧ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿の一覧ページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')
 
@section('content')
<div class="container mt-4">
    <div class="border p-4">
        <div class="mb-4 text-right">
          @auth
            @can('edit', $post)
                <a href="{{ action('PostsController@edit', $post->id) }}" class="btn btn-info">
                  編集する
                </a>
                <form
                    style="display: inline-block;"
                    method="POST"
                    action="{{ action('PostsController@destroy', $post->id) }}" >
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="削除する" onclick='return confirm("本当に削除してよろしいですか？");'>
                </form>
            @endcan
          @endauth
        </div>
      <!-- 画像 --> 
      <h1 class="h4 mb-4">
         @if (empty($post->image_file))
         @else
         <td><img src="{{ Storage::disk('s3')->url($post->image_file) }}" width="500px"></td>
         @endif
      </h1>
      <!-- 件名 -->
      <h1 class="h4 mb-4">
          {{ optional ($post)->subject }}
      </h1>
      <!-- 投稿情報 -->
      <div class="summary">
          <p><span>{{ optional ($post)->user->name }}</span> / <time>{{ optional ($post->updated_at)->format('Y.m.d H:i') }}</time> / {{ optional ($post->category)->name }} / {{ $post->id }}</p>
      </div>

      <!-- 本文 -->
      <p class="mb-5">
          {!! nl2br(e($post->message)) !!}
      </p>

      <section>
          <h2 class="h5 mb-4">
              コメント
          </h2>
          <form class="mb-4" method="POST" action="{{ route('comment.store') }}">
              @csrf
              <input
                name="post_id"
                type="hidden"
                value="{{ $post->id }}"
              >
              <div class="form-group">
                <label for="body">
                本文
                </label>
                  <textarea
                      id="comment"
                      name="comment"
                      class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                      rows="4"
                  >{{ old('comment') }}</textarea>
                  @if ($errors->has('comment'))
                  <div class="invalid-feedback">
                      {{ $errors->first('comment') }}
                  </div>
                  @endif
              </div>
              @if (session('commentstatus'))
                  <div class="alert alert-success mt-4 mb-4">
                    {{ session('commentstatus') }}
                  </div>
              @endif

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">
                コメントする
              </button>
              @forelse($post->comments()->orderBy('id', 'desc')->get() as $comment)
                    <div class="border-top p-4">
                        <time class="text-secondary">
                            {{ $comment->user->name}}
                            {{ optional ($comment->created_at)->format('Y.m.d H:i') }} / 
                            {{ optional ($comment)->id }}
                        </time>
                        <p class="mt-2">
                            {!! nl2br(e($comment->comment)) !!}
                        </p>
                    </div>
                    @empty
                      <p>コメントはまだありません。</p>
                @endforelse
            </div>
          </form>
      </section>
  </div>
    <div class="mt-4 mb-4">
      <a href="{{ route('bbs.index') }}" class="btn btn-info">
          一覧に戻る
      </a>
    </div>
</div>
@endsection
@include('layouts.bbsfooter')

