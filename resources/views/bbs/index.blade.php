@extends('layouts.bbslayout')
 
@section('title', '投稿の一覧ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿一覧ページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')
@section('content')

<div class="center jumbotron bg-secondary">

    <img id="change" class="rounded img-fluid" src="https://images.unsplash.com/photo-1463043254199-7a3efd782ad1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" style="width:1046px; height:200px; object-fit:cover; object-position:0% 33%;">

    <div class="text-center text-white mt-5 pt-1">

        <h1 class="matome">Biborokuまとめ ｘ</h1>
        <h1 class="matome">コミュニケーション</h1>

    </div>

</div>

<h5 class="description text-right">みんなが "シェアしたい" 画像を自由にシェアできる</h5>
        <h5 class="description2 text-right">< 画像投稿コミュニケーションサービス ></h5>

<div class="mt-4 mb-4">
    <a href="{{ route('bbs.create') }}" class="btn btn-primary">
        投稿の新規作成
    </a>
</div>
<!-- 検索フォーム -->
<div class="mt-4 mb-4">
    <form class="form-inline" method="GET" action="{{ route('bbs.index') }}">
        <div class="form-group">
            <input type="text" name="searchword" value="{{$searchword}}" class="form-control" placeholder="検索ワードを入力">
        </div>
        <input type="submit" value="検索" class="btn btn-info ml-2">
    </form>
</div>
@if (session('poststatus'))
    <div class="alert alert-success mt-4 mb-4">
        {{ session('poststatus') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>作成日時</th>
            <th>名前</th>
            <th>件名</th>
            <th>画像</th>
            <th>メッセージ</th>
            <th>処理</th>
        </tr>
        </thead>
        <tbody id="tbl">
        @foreach ($posts as $post)
            <tr>
                <td>{{ optional ($post)->id }}</td>
                <td>{{ optional ($post->created_at)->format('Y.m.d') }}</td>
                <td>{{$post->user->name}}</td>
                <td>{{ optional ($post)->subject }}</td>
                <td>
                    @if (empty($post->image_file))
                    
                    @else
                        <img src="{{ Storage::disk('s3')->url($post->image_file) }}" width="150px">
                    @endif
                </td>
                <td>{!! nl2br(e(Str::limit($post->message, 100))) !!}
                @if ($post->comments->count() >= 1)
                    <p><span class="badge badge-primary">コメント：{{ optional ($post->comments)->count() }}件</span></p>
                @endif
                </td>
                <td class="text-nowrap">
                    <p><a href="{{ action('PostsController@show', $post->id) }}" class="btn btn-primary btn-sm">詳細</a></p>
                    @can('edit', $post)
                        <p><a href="{{ action('PostsController@edit', $post->id) }}" class="btn btn-info btn-sm">編集</a></p>
                        <p>
                            <form method="POST" action="{{ action('PostsController@destroy', $post->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </p>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@include('posts.index')
@endsection
@include('layouts.bbsfooter')
