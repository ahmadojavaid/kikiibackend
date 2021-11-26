@extends('layouts.datatableLayoutMaster')
@section('title' , 'Kikii Posts')
@section('content')

<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Kikii Posts</h4>
            <div class="col-12">
              <a href="{{ route('Post.create') }}" class="btn btn-primary btn-md pull-right"><i class="fa fa-plus fa-lg"></i> Create New Post</a>
            </div>       
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="post_table" >
                  <thead>
                      <tr>
                        <th> No.</th>
                        <th> Post</th>
                        <th> Action</th>
                      </tr>
                  </thead>
                  <tbody>
                     @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->body }}</td>

                            <td>
                                <form action="{{ route('Post.destroy',$post->id) }}" method="POST">

                                    <a class="btn btn-info" href="{{ route('Post.show',$post->id) }}">Show</a>

                                    <a class="btn btn-primary" href="{{ route('Post.edit',$post->id) }}">Edit</a>

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>





@endsection

@section('page-script')

    <script type="text/javascript">

        //DATA TAble
        $(document).ready( function () {
          
          $('#post_table').DataTable();
        });


    </script>
@endsection