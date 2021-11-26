<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\User;
use Response;
use Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function login()
    {
        return redirect('/login');
    }
     
   
    public function index()
    {
        return view('home');
    }

    public function show(){

        if(!\Gate::allows('isAdmin')){
            abort(404,"Sorry you can not do this action");
        }
        
        return view('pages/user');
    }

    public function userlisting(Request $request){


        if ($request->ajax()) {
    $data = User::select(['id','name','email','role'])
    ->where('role','=','user')
    ->withCount('likes')->get();
   

// dd($data);

    return Datatables::of($data)
    ->addIndexColumn()
    ->addColumn('action', function($data){
                   
        $editUrl = url('user/edit/'.$data->id);
        $viewUrl = url('show-user/'.$data->id);
        $deleteUrl = url('delete/'.$data->id);
        // $btn = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

        $btn =  '<a href="'.$viewUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-info btn-sm">Show</a>';
        $btn = $btn.' <a href="'.$deleteUrl.'" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTodo">Delete</a>';

        // if ($data->is_active == 1) {
        // $btn=$btn.' <a href="'.$deleteUrl.'" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTodo">Deactivate</a>';
        // }else{
        //     $btn=$btn.' <a href="'.$deleteUrl.'" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTodo">Deactivate</a>';
        // }
         return $btn;
       
 })



 ->addColumn('likes_count',function($data){
     $likes=$data->likes_count;

     return $likes;
 })
 ->rawColumns(['action','likes'])
 ->make(true);
            
    }

}

public function edituser($id){
    // dd("rr");
$user['todo'] = User::find($id);
        return view('pages.admin.edit',$user);

    }

public function showUser($id){

    $showUser = User::findOrFail($id);
    return view('pages.admin.show', compact('showUser'));
}

public function update(Request $request)
    {
        
        $check = User::where('id', $request->id)->update(
            [
                'name'=>$request->name,
                'email'=>$request->email
            ]
        );
        return redirect('/show');
    }  

public function delete($id)
{
       $data = User::findOrFail($id);
        $data->delete();

         return redirect()->back()
        ->with('error','user deleted succefully');
}


    
}
