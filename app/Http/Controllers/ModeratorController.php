<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\User;
use Gate;
class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        if(!\Gate::allows('isAdmin')){
            abort(404,"Sorry you can not do this action");
        }
        
        if(request()->ajax()) {
            $data = User::select(['id','name','email','profile_pic','role'])->where('role','=','moderator');
            return Datatables::of($data)
            
                // return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
                // return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
            ->addColumn('profile_pic', function ($data) { 
                $url=$data->profile_pic;
                 
                return '<img src='.$url.' border="0" width="50" class="img-rounded" align="center" />'; 
                
            })
            ->addColumn('action', function($data){
                           
                $editUrl = url('moderator/'.$data->id.'/edit');
                $deleteUrl = url('moderator/'.$data->id);
                $btn = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTodo">Delete</a>';
        

                return $btn;
        
                
         })
         ->rawColumns(['action','profile_pic'])
         ->make(true);

        }
                    
        return view('pages.moderator.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('pages.moderator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());

        // $this->validate(request(), [
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'file' => 'required|image|mimes:jpg,jpeg,png,gif'
        // ]);
    


        // $fileName = null;
        // if (request()->file('profile_pic')) {
        // $file = request()->file('profile_pic');
        // $fileName = time().'.'.$file->getClientOriginalExtension();
        // // dd($fileName);
        // // $file->move('./uploads/profile_pic/', $fileName);   
        // $file->move(public_path('profile_pic'),$fileName);
        // }
;

        $user= User::create([
        'name' => request()->get('name'),
        'email' => request()->get('email'),
        'password' => request()->get('passsword'),
        'profile_pic' => request()->file('profile_pic'),
        
    ]);

    if($user->id >0){

        User::where('id',$user->id )->update(['role'=>'moderator']);

        return redirect()->to('/moderator');

    }

   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $modular=User::find($id);
        return view('pages.moderator.edit')->with('modular',$modular);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $user = User::find($id);
        $user->name =  $request->get('name');
        $user->email = $request->get('email');
        $user->profile_pic = $request->file('profile_pic');
        $user->save();

        return redirect('/moderator')->with('success', 'Contact updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $moderator = User::where('id', $id)->delete();
 
        return redirect('/events');
    }
}
