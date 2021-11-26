@extends('layouts.datatableLayoutMaster')

@section('title' , 'User Report')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">User Reports</h4>     
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="user_report_table" >
                  <thead>
                    <tr>
                        <td>ID</td>
                        <td>Reported By</td>
                        <td>user Id</td>
                        <td colspan = 2>Actions</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($userReport as $repo)
                        <tr>
                            <td>{{$repo->id}}</td>
                            <td>{{$repo->user->name ?? "Kikii User"}}</td>
                            <td>{{$repo->user_id}}</td>
                            <td>
                                <form action="{{ route('userreports.destroy', $repo->id)}}" method="post">
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

<script>
    $(document).ready(function() {
        $('#user_report_table').DataTable();
    });
</script>

@endsection