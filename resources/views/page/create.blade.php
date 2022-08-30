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
          <form method="POST" id="myform" role="form" >
            @csrf
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}"/>
                    <p id='titlee' style="max-height:3px;"></p>
                </div>
                <div class="form-group">
                    <label class="control-label" for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control" rows="4" name="content" id="content">{{ old('content') }}</textarea>
                    <p id='contente' style="max-height:3px;"></p>
                </div>

                <div class="form-group">
                    <label for="parent">Parent Page <span class="m-l-5 text-danger"> *</span></label>
                    <select id=parent class="form-control custom-select mt-15" name="parent_id">
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
                    <p id='parent_ide' style="max-height:3px;"></p>
                </div>
            </div>
            <div class="tile-footer">
                <div class="row d-print-none mt-2">
                    <div class="col-12 text-right">
                        <button class="btn btn-success" type="submit" id="page_store"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Page</button>
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

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#page_store').click(function (e) {
                e.preventDefault();
                var form = $('#myform')[0];
                var formData = new FormData(form);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{route('pages.store')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        console.log(result);
                        if (result.errors)
                        {
                            if (result.errors['title'])
                            {
                                $('#titlee').empty();
                                $('#titlee').show();
                                $('#titlee').append('<span class="text-danger">'+result.errors.title+'</span>');
                            }else{
                                $('#titlee').empty();
                            }
                            if(result.errors['content']){
                                $('#contente').empty();
                                $('#contente').show();
                                $('#contente').append('<span class="text-danger">'+result.errors.content+'</span>');
                            }else{
                                $('#contente').empty();
                            }
                            if(result.errors['parent_id']){
                                $('#parent_ide').empty();
                                $('#parent_ide').show();
                                $('#parent_ide').append('<span class="text-danger">'+result.errors.parent_id+'</span>');
                            }else{
                                $('#parent_ide').empty();
                            }
                        }
                        else {
                            $('#titlee').empty();
                            $('#contente').empty();
                            $('#parent_ide').empty();
                            toastr.success(result.message);

                            setTimeout(redirectFunc, 3000);

                        }
                    },
                    error: function( _response ){
                        // Handle error
                        toastr.error(_response.errors);
                    }
                });
            });

            function redirectFunc(){
                window.location.href = "{{ route('pages.index')}}";
            }
        });
    </script>
@endpush
