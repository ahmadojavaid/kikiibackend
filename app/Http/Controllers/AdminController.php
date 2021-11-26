<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Helpers\Helper;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    {   
        $user = Auth::user();
        return view('pages.admin.profile', compact('user'));
    }
    public function update(Request $request){

        // dd($request->all());

        $input=$request->all();
        $User_id = Auth::user()->id;

        $user = User::findorFail($User_id);
        $user->update($input);
        // dd( $user );

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function approve($id){
        $leave = User::find($id);
        $leave->status = 1; //Approved
        $leave->save();
        return redirect('/home'); //Redirect user somewhere
     }

     public function decline($id){
        $leave = User::find($id);
        $leave->status = 0; //Declined
        $leave->save();
        return redirect('home'); //Redirect user somewhere
     }

    public function checkUsers(Request $request)
    {
        $users = \Artisan::call('check:user');
    }


}
