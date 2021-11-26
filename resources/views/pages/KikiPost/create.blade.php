@extends('layouts.contentLayoutMaster')

@section('content')

    <div class="col-md-12 col-12">
        <div class="card" >
            <div class="card-header">
                <h4 class="card-title">Add Post</h4>
                <div class="col-12">
                  <a href="{{ route('Post.index') }}" class="btn btn-warning btn-md pull-right"><i class="fa fa-arrow-left fa-lg"></i> Back</a>
                </div>  
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{route('Post.store')}}">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="row">


                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span> Body</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <textarea class="form-control" id="basicTextarea" name="body" rows="3" placeholder="Textarea"></textarea>
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                    <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection