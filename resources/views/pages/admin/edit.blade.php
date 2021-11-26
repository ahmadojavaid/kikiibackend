@extends('layouts.contentLayoutMaster')

@section('content')


<div class="container mt-5">
   
    <form id="add-todo" method="post" action="{{ route('update-user',$todo->id) }}"> 
      @csrf
      
      <input type="hidden" name="id" class="form-control" value="{{ $todo->id }}" id="formGroupExampleInput">

      <div class="form-group">
        <label for="formGroupExampleInput">Name</label>
        <input type="text" name="name" class="form-control"  placeholder="Please enter title" value="{{ $todo->name }}">
        <span class="text-danger">{{ $errors->first('title') }}</span>
      </div> 

      <div class="form-group">
        <label for="message">Email</label>
        <textarea name="email" class="form-control"  placeholder="Please enter description">{{ $todo->email }}</textarea>
        <span class="text-danger">{{ $errors->first('description') }}</span>
      </div>

      <div class="form-group">
       <button type="submit" class="btn btn-success" id="btn-send">Submit</button>
      </div>
    </form>
 
</div>


@endsection 