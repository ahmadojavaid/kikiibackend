@extends('layouts.datatableLayoutMaster')

@section('title' , 'Events')

@section('content')
<section id="horizontal-vertical">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Events</h4>               
            <div class="col-12">
              <a href="{{ route('events.create') }}" class="btn btn-primary btn-md pull-right"><i class="fa fa-plus fa-lg"></i> Create New Post</a>
            </div>        
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table nowrap scroll-horizontal-vertical data-table-setter" id="event_table" >
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>description</th>
                        <th>Date</th>
                        <th>cover</th>
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // $.fn.dataTable.ext.errMode = 'none';
      $('#event_table').DataTable({
          
           "Processing": true,
           "ServerSide": true,
           "ajax":"events",
           "order": [],
           "columns": [
           {"data": 'id'},
           { "data":"name" },
           { "data":"description" },
           { "data":"datetime" },
           { "data": "cover_pic" },
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
       url: "{{ url('events/destroy') }}"+'/'+todo_id,
       success: function (data) {
       var oTable = $('#event_table').dataTable(); 
       $('#event_table').DataTable().ajax.reload();
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