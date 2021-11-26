<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserReport;

class ReportsController extends Controller
{
   
        public function index(){
            $userReport=UserReport::with('user','post','report')->get();
            // dd($userReport);
            
            return view('pages.user-reporting.index')->with('userReport',$userReport);
        }

        public function destroy(Request $request,$id)
        {
            $contact = UserReport::find($id);
            $contact->delete();
    
            return redirect('/user/report')->with('success', 'Report deleted!');
        }
}
