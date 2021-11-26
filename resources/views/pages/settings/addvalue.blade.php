@extends('layouts.contentLayoutMaster')

@section('title' , 'Add Category Values')

@section('content')

@section('page-style')

<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">

@endsection



<div class="col-md-12 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Category Values</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" action="{{route('value.add')}}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="row">


                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Category</span>
                                    </div>
                                    <div class="col-md-8">
                                        <fieldset class="form-group">
                                            <select class="form-control" name="category" id="users-list-role">
                                                <option>Select category</option>
                                                @foreach ($cat as $category)
                                                <option value='{{ $category->id }}'>{{ $category->key }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>





                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Add value</span>
                                    </div>

                                    <div class="col-md-8">
                                  
                                <select class="form-control" multiple="multiple" id="moviesselect2"  name="value[]">
                               
                                </select>
                            
                                    </div>
                                </div>

                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                    <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('page-script')

<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

<script src="{{asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>

<script src="{{asset('app-assets/js/scripts/pages/account-setting.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#users-list-role").on("change",function(){
            var value = $(this).val();
            $.ajax({
                type:"GET",
                url:"{{url('populate')}}",
                data:{
                    value:value
                },
                success:function(result){
                    console.log( result);
                    alert('hello');
                    
                    result.forEach((text , index) => {
                        

                        var newOption = new Option(text, text, true, true);
                       
                        // $('#mySelect2').append(newOption).trigger('change');

                        // $("#moviesselect2").append(newOption).trigger('change');

                        
                        
                        $("#moviesselect2").append(newOption).trigger('change');

                       
                       
                    });

                     $('#moviesselect2').val(null);
                    //  $('#mySelect2').val(null).trigger('change');

                    
                }
            });
        });
    })
</script>

@endsection