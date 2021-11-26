<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Privacy;

class privacyController extends Controller
{

    public function create(){
        $privacy=Privacy::first();
        return view('pages.privacy.create')->with('privacy',$privacy);
    }

    public function store(Request $request,$id){

        // dd($request->all());

        $post = Privacy::find($id);
        if($post){
        $post->update($request->all());
        }else{
            $post->create($request->all());
        }
    

            return redirect()->back()->with('success', 'Profile updated successfully');


        }
         
       
}
