@extends('layouts.bbslayout')
 
@section('title', 'ユーザ登録ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', 'ユーザ登録ページの説明文')
@section('pageCss')
<link href="/css/bbs/style.css" rel="stylesheet">
@endsection
 
@include('layouts.bbsheader')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
     <div class="card">
       <div class="card-header">{{ __('新規登録') }}</div>
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
         <form action="{{route('user.store')}}" method="POST">
           @csrf
           <div class="form-group">
             <label for="name">{{ __('Name') }}</label>
             <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control">
           </div>
           <div class="form-group">
             <label for="email">{{ __('E-Mail Address') }}</label>
             <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control">
           </div>
           <div class="form-group">
             <label for="password">{{ __('Password') }}</label>
             <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control">
           </div>
           <div class="form-group">
             <label for="password">{{ __('Confirm Password') }}</label>
             <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control">
           </div>
           <button type="submit" class="btn btn-primary">新規登録</button>
         </form>
       </div>
     </div>
   </div>
 </div>
</div>
@endsection
@include('layouts.bbsfooter')