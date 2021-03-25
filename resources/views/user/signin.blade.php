@extends('layouts.bbslayout')
 
@section('title', 'ログインページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', 'ログインページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection

@include('layouts.bbsheader')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
     <div class="card">
       <div class="card-header">{{ __('ログイン') }}</div>
       <div class="card-body">
         @if (count($errors) > 0)
         <div class="errors">
           <ul>
             @foreach ($errors->all() as $error)
               <li>{{$error}}</li>
             @endforeach
           </ul>
         </div>
         @endif
         <form action="{{route('user.login')}}" method="POST">
           @csrf
           <div class="form-group">
             <label for="email">{{ __('E-Mail Address') }}</label>
             <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control">
           </div>
           <div class="form-group">
             <label for="password">{{ __('Password') }}</label>
             <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control">
           </div>
           <button type="submit" class="btn btn-primary">ログイン</button>
         </form>
       </div>
     </div>
   </div>
 </div>
</div>
@endsection
@include('layouts.bbsfooter')