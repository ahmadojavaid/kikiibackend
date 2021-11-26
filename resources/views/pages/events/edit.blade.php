@extends('layouts.simpleFormLayoutMaster')

@section('title' , 'Edit Event')

@section('content')

    <div class="col-md-12 col-12">
        <div class="card" >
            <div class="card-header">
                <h4 class="card-title">Edit Event</h4>
                <div class="col-12">
                  <a href="{{ route('events.index') }}" class="btn btn-warning btn-md pull-right"><i class="fa fa-arrow-left fa-lg"></i> Back</a>
                </div>  
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{route('events.update' , $event->id)}}">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <div class="form-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span> Name</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input class="form-control" id="name" name="name" rows="3" placeholder="Event Name" required value="{{ $event->name }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span> Description</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Event Description" required>{{ $event->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span> Date Time</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="date" class="form-control" id="datetime" name="datetime" required value="{{ $event->datetime }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span> Cover Photo</span>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative has-icon-left">
                                                <input type="file" class="form-control" id="cover_pic" name="cover_pic" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative has-icon-left">
                                                <img src="{{ $event->cover_pic }}" height="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection