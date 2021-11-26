@extends('layouts.datatableLayoutMaster')

@section('title' , 'Reports')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Reports</h4>     
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="report_table" >
                  <thead>
                      <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Title</td>
                        <td>Reports</td>
                        <td>Report Type</td>
                        <td colspan = 2>Actions</td>
                      </tr>
                  </thead>
                  <tbody>
                     @foreach($reports as $report)
                      <tr>
                          <td>{{$report->id}}</td>
                          <td>{{$report->user->name ?? "Kikii User"}}</td>
                          <td>{{$report->title}}</td>
                          <td>{{$report->text}}</td>
                          @if($report->post_id)
                            <td>Post</td>
                          @elseif($report->user_id)
                            <td>User</td>
                          @elseif($report->comment_id)
                            <td>Comment</td>
                          @endif                          
                          <td>
                              <form action="{{ route('reports.destroy', $report->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
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
          
          $('#report_table').DataTable();
        });


    </script>
@endsection