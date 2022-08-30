@extends('app')
@section('title') Page List @endsection

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>Page List</h2>
        <p class="lead"><a href="{{route('pages.create')}}" class="btn btn-outline-info btn-md px-4 me-sm-3 fw-bold">Create Page</a></p>
      </div>
      @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
      @endif
      <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                      <th scope="col">#ID</th>
                      <th scope="col">Parent</th>
                      <th scope="col">Title</th>
                      <th scope="col">Content</th>
                      <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i = 1; @endphp
                    @forelse($pages as $item)
                        @if($item->parent != NULL)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->parent->title ?? 'N/A' }}</td>
                            <td>{{ ($item->title) ?? 'N/A' }}</td>
                            <td>{{ ($item->content) ?? 'N/A' }} </td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="{{ route('pages.show', $item->getAncestorsAndSelf()->pluck('slug')->implode('/')) }}" class="btn btn-sm btn-info text-white">View</i></a>
                                    <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</i></a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="deletePost({{ $item->id }})">Delete</i></a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('pages.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <td colspan="5" class="text-center">No Data Found</td>
                    @endforelse
                  </tbody>
            </table>
      </div>
  </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.1/sweetalert2.all.js"></script>
    <script type="text/javascript">
        function deletePost(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
