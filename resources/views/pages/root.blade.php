
@extends('layouts.app')
@section('title', '首页')

@section('content')
  <h1>这里是首页</h1>
  <input type="text" name="_token" value="{{ csrf_token() }}" />
@stop
