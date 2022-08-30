@extends('app')
@section('title') {{$page->title ?? 'N/A'}} @endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>{{$page->title ?? 'N/A'}}</h2>
      </div>
      <div class="row">
           {!! $page->content ?? 'N/A' !!}
      </div>
</div>
@endsection
