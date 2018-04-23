@extends('layouts.default')
@section('title', '所有用户')

@section('content')
@include('shared._messages')
<div class="col-md-offset-2 col-md-8">
  <h1>所有用户</h1>
  <ul class="users">
    @foreach ($users as $user)
      @include('user._user', $user)
    @endforeach
  </ul
  {!! $users    ->render() !!}
</div>    
@stop
