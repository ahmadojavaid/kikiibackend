@extends('layouts.datatableLayoutMaster')

@section('title' , 'Moderator')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Moderator</h4>     
            <div class="col-12">
              <a href="{{route('moderator.create')}}" class="btn btn-primary btn-md pull-right"><i class="fa fa-plus fa-lg"></i> Add New Moderator</a>
            </div> 
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="moderator_table" >
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>profile</th>
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
      $('#moderator_table').DataTable({
          
           "Processing": true,
           "ServerSide": true,
           "ajax":"moderator",
           "order": [],
           "columns": [
           {"data": 'id'},
           { "data":"name" },
           { "data":"email" },
           { "data":"role" },
           { "data": "profile_pic" },
           {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
          
           ]
      });

  });

  $('body').on('click', '.deleteTodo', function () {
 
 var todo_id = $(this).data("id");
 if(confirm("Are You sure want to delete !"))
 {
   $.ajax({
       type: "get",
       url: "{{ url('moderator/destroy') }}"+'/'+todo_id,
       success: function (data) {
       var oTable = $('#moderator_table').dataTable(); 
       $('#moderator_table').DataTable().ajax.reload();
       oTable.fnDraw(false);
       },
       error: function (data) {
           console.log('Error:', data);
       }
   });
}
});   

 </script>

@endsection