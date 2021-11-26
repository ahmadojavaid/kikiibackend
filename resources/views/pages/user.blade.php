@extends('layouts.datatableLayoutMaster')

@section('title' , 'Users')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Users</h4>     
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="user_table" >
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Likes</th>
                        <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
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
    // $.fn.dataTable.ext.errMode = 'none';
      $('#user_table').DataTable({
          
           "Processing": true,
           "ServerSide": true,
           "ajax":"user",
           "order": [],
           "columns": [
           {"data": 'id'},
           { "data":"name" },
           { "data":"email" },
           { "data":"likes_count" },
      
           {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
           ]
      });

  });

 

</script>

@endsection






                    




