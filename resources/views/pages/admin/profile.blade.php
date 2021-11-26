@extends('layouts.contentLayoutMaster')
@section('content')



 <div class="card-content">
    <div class="card-body">
        <div class="tab-content">
        <form enctype="multipart/form-data" method="post" action="{{route('admin-update')}}">
        {{ csrf_field() }}
         {{ method_field('post') }}
    
            <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                <div class="media">
                   
                        <img id="blah" src="{{$user->profile_pic}}" class="rounded mr-75" name="profile_pic" alt="profile image" height="64" width="64">
                   
                    <div class="media-body mt-75">
                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                           
                            <input type="file" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light"  id="account-upload" name="profile_pic" onchange="loadFile(event)">
                        </div>
                        <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max
                                size of
                                800kB</small></p>
                    </div>
                </div>
                <hr>
                <form novalidate="">
                    <div class="row">
                       
                        <div class="col-12">
                            <div class="form-group">
                                <div class="controls">
                                    <label for="account-name">Name</label>
                                    <input type="text" class="form-control" id="account-name" name="name" placeholder="Name" value="{{$user->name}}" required="" data-validation-required-message="This name field is required">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="controls">
                                    <label for="account-e-mail">E-mail</label>
                                    <input type="email" class="form-control" id="account-e-mail" name="email" placeholder="Email" value="{{$user->email}}" required="" data-validation-required-message="This email field is required">
                                </div>
                            </div>
                        </div>
                        
                       
                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 waves-effect waves-light">Save
                                changes</button>
                            <button type="reset" class="btn btn-outline-warning waves-effect waves-light">Cancel</button>
                        </div>
                    </div>
            </div>
           
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
var loadFile = function(event) {
    var output = document.getElementById('blah');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

</script>
@endsection