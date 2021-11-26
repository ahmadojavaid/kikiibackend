@extends('layouts.contentLayoutMaster')

@section('content')



<section class="page-users-view">
                    <div class="row">
                        <!-- account start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Account</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    <a href="#" class="pop">
                                            <img src="{{$showUser->profile_pic}}" class="gallerythumbnail" alt="avatar" height="200" width="200">
                                        </a>

                                    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" data-dismiss="modal">
                                    <div class="modal-content"  >              
                                    <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <img src="{{$showUser->profile_pic}}" class="imagepreview" style="width: 100%;" >
                                    </div> 
                                    </div>
                                    </div>

                                    </div>
                                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                        <table class="table table-striped">
                                                <tbody>
                                                
                                                <tr>
                                                    <td class="font-weight-bold">Name:</td>
                                                    <td>{{$showUser->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Email:</td>
                                                    <td>{{$showUser->email}}</td>
                                                </tr>
                                            </tbody>
                                            
                                            </table>
                                            <div class="col-12">
                                            <a href="{{route('admin.approve',$showUser->id)}}" class="btn btn-success">Approve</a> 
                                            <a href="{{route('admin.decline',$showUser->id)}}" class="btn btn-danger">Decline</a>

                                          
                                        </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-5">
                                        <table class="table table-striped">
                                                <tbody><tr>
                                                    <td class="font-weight-bold">Status:</td>
                                                    <td>{{$showUser->status}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Role:</td>
                                                    <td>{{$showUser->role}}</td>
                                                </tr>

                                                
                                                
                                            </tbody>
                                            </table>

                                            
                                        </div>
                                        
                                        </br>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- account end -->
                        <!-- information start -->
                        <div class="col-md-6 col-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-2">Information</div>
                                </div>
                                <div class="card-body">
                                <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td class="font-weight-bold">birthday </td>
                                            <td>{{$showUser->birthday}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">phone</td>
                                            <td>{{$showUser->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">gender_identity</td>
                                            <td>{{$showUser->gender_identity}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">sexual_identity</td>
                                            <td>{{$showUser->sexual_identity}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">pronouns</td>
                                            <td>{{$showUser->pronouns}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">bio</td>
                                            <td>{{$showUser->bio}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">relationship_status</td>
                                            <td>{{$showUser->relationship_status}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">height</td>
                                            <td>{{$showUser->height}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">looking_for</td>
                                            <td>{{$showUser->looking_for}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">drink</td>
                                            <td>{{$showUser->drink}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">smoke</td>
                                            <td>{{$showUser->smoke}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">cannabis</td>
                                            <td>{{$showUser->cannabis}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">political_views</td>
                                            <td>{{$showUser->political_views}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">religion</td>
                                            <td>{{$showUser->religion}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">diet_like</td>
                                            <td>{{$showUser->diet_like}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">sign</td>
                                            <td>{{$showUser->sign}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">pets</td>
                                            <td>{{$showUser->pets}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">kids</td>
                                            <td>{{$showUser->kids}}
                                            </td>
                                        </tr>

                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                        <!-- information start -->
                        <!-- social links end -->
                        <div class="col-md-6 col-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-2">Social Links</div>
                                </div>
                                <div class="card-body">
                                    <table>
                                        <tbody><tr>
                                            <td class="font-weight-bold">Twitter</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Facebook</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Instagram</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td class="font-weight-bold">Github</td>
                                            <td>https://github.com/madop818
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">CodePen</td>
                                            <td>https://codepen.io/adoptism243
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Slack</td>
                                            <td>@adoptionism744
                                            </td>
                                        </tr> -->
                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                        <!-- social links end -->
                        <!-- permissions start -->
                        <!-- <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom mx-2 px-0">
                                    <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>Permission
                                    </h6>
                                </div>
                                <div class="card-body px-75">
                                    <div class="table-responsive users-view-permission">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th>Read</th>
                                                    <th>Write</th>
                                                    <th>Create</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Users</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox1" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox1"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox2" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox2"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox3" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox4" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox4"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Articles</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox5" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox5"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox6" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox6"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox7" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox7"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox8" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox8"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Staff</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox9" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox9"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox10" class="custom-control-input" disabled="" checked="">
                                                            <label class="custom-control-label" for="users-checkbox10"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox11" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox11"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox ml-50"><input type="checkbox" id="users-checkbox12" class="custom-control-input" disabled=""><label class="custom-control-label" for="users-checkbox12"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- permissions end -->
                    </div>
                </section>


@endsection

@section('page-script')

<script>
// $(document).ready(function() {
//     $('.gallerythumbnail').on('click', function() {
//         var img = $('<img />', {
//                       src     : this.src,
//                       'class' : 'fullImage'
//                   });

//         $('.users-view-image').html(img).show();
//     });
// });

$(function() {
		$('.pop ').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});

</script>



@endsection