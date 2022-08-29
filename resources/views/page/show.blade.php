@extends('app')
@section('title') Pages @endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>Page List</h2>
        <p class="lead">{{$page->title ?? 'N/A'}}</p>
      </div>
      <div class="row">
           {!! $page->content ?? 'N/A' !!}
      </div>
</div>
@endsection
