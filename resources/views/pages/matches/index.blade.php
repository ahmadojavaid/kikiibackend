
@extends('layouts.datatableLayoutMaster')

@section('title' , 'Matches')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Matches</h4>     
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="match_table" >
                  <thead>
                    <tr>
                        <td>ID</td>
                        <td>User</td>
                        <td>User</td>
                        <td>Status</td>
                        <td >Actions</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($match as $matches)
                        <tr>
                            <td>{{$matches->id}}</td>
                            <td>{{$matches->usermatch->name}}</td>
                            <td>{{$matches->likes->name}}</td>
                            <td>{{$matches->matched}}</td>
                            <td>
                                <form action="{{ route('match.destroy', $matches->id)}}" method="post">
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
        $('#match_table').DataTable();
    });
</script>

@endsection