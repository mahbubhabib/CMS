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
          <form method="POST" id="myform" role="form" >
            @csrf
            <input type="hidden" name="id" value="{{$page->id}}"/>
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $page->title ?? '' }}"/>
                    <p id='titlee' style="max-height:3px;"></p>
                </div>
                <div class="form-group">
                    <label class="control-label" for="content">Content<span class="text-danger"> *</span></label>
                    <textarea class="form-control" rows="4" name="content" id="content">{!! $page->content ?? '' !!}</textarea>
                    <p id='contente' style="max-height:3px;"></p>
                </div>

                <div class="form-group">
                    <label for="parent">Parent Page <span class="m-l-5 text-danger"> *</span></label>
                    <select id=parent_id class="form-control custom-select mt-15" name="parent_id" required>
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
                    <p id='parent_id' style="max-height:3px;"></p>
                </div>
            </div>
            <div class="tile-footer">
                <div class="row d-print-none mt-2">
                    <div class="col-12 text-right">
                        <button class="btn btn-success" type="submit" id="page_update"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Page</button>
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
            $('#page_update').click(function (e) {
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
                    url: "{{route('pages.update')}}",
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
