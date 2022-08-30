@extends('app')
@section('title') Page Create @endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>Page Create</h2>
        <p class="lead"><a href="{{route('pages.index')}}" class="btn btn-outline-info btn-md px-4 me-sm-3 fw-bold">Go Back</a></p>
      </div>

      <div class="row g-5">
        <div class="col-md-6 col-sm-4">
          <form action="{{ route('pages.store')}}" method="POST" role="form" >
            @csrf
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                     @error('title') <i class="fa fa-exclamation-circle fa-fw"></i> <span>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" rows="4" name="content" id="content">{{ old('content') }}</textarea>
                    @error('content') <i class="fa fa-exclamation-circle fa-fw"></i> <span>{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="parent">Parent Page <span class="m-l-5 text-danger"> *</span></label>
                    <select id=parent class="form-control custom-select mt-15 @error('parent_id') is-invalid @enderror" name="parent_id">
                        @foreach($pages as $page)
                            @if($page->parent_id == 0)
                                <option value="{{$page->id}}">{{$page->title}}</option>
                            @endif
                                    @if($page->parent_id == 1)
                                        <option value="{{$page->id}}" class="font-weight-bold">{{$page->title}}</option>
                                    @endif
                                        @foreach($page->children as $child)
                                            @if($child->parent_id != 1 && $page->parent_id == 1)
                                                <option value="{{ $child -> id }}">
                                                   - {{ $child->title }}
                                                </option>
                                            @endif
                                                @foreach($child->children as $grandchild)
                                                    @if($page->parent_id == 1 )
                                                        <option value="{{ $grandchild->id }}">
                                                            -- {{ $grandchild->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                        @endforeach
                                @endforeach
                    </select>
                    @error('parent_id') <i class="fa fa-exclamation-circle fa-fw"></i> <span>{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="tile-footer">
                <div class="row d-print-none mt-2">
                    <div class="col-12 text-right">
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Page</button>
                        <a class="btn btn-danger" href="{{ route('pages.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
@endsection
