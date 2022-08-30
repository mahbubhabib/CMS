@extends('app')
@section('title') Edit Page @endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>Update Page</h2>
        <p class="lead"><a href="{{route('pages.edit',$page->id)}}" class="btn btn-outline-info btn-md px-4 me-sm-3 fw-bold">Go Back</a></p>
      </div>

      <div class="row g-5">
        <div class="col-md-6 col-sm-4">
          <form action="{{ route('pages.update',$page->id)}}" method="POST" role="form" >
            @csrf
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ $page->title ?? '' }}"/>
                    @error('title') <i class="fa fa-exclamation-circle fa-fw"></i> <span>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" rows="4" name="content" id="content">{!! $page->content ?? '' !!}</textarea>
                    @error('content') <i class="fa fa-exclamation-circle fa-fw"></i> <span>{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="parent">Parent Page <span class="m-l-5 text-danger"> *</span></label>
                    <select id=parent_id class="form-control custom-select mt-15 @error('parent_id') is-invalid @enderror" name="parent_id" required>
                        @foreach($pages as $pg)
                            @if($pg->parent_id == 0)
                                <option value="{{$pg->id}}" {{($pg->id == $page->parent_id) ? 'selected' : ''}}>{{$pg->title}}</option>
                            @endif
                            @if($pg->parent_id == 1)
                                <option value="{{$pg->id}}" class="font-weight-bold" {{($pg->id == $page->parent_id) ? 'selected' : ''}}>{{$pg->title}}</option>
                            @endif
                            @foreach($pg->children as $child)
                                @if($child->parent_id != 1 && $pg->parent_id == 1)
                                    <option value="{{ $child->id }}" {{($child->id == $page->parent_id) ? 'selected' : ''}}>
                                        - {{ $child->title }}
                                    </option>
                                @endif
                                @foreach($child->children as $grandchild)
                                    @if($pg->parent_id == 1 )
                                        <option value="{{ $grandchild->id }}" {{($grandchild->id == $page->parent_id) ? 'selected' : ''}}>
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
                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Page</button>
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
