<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Term;

class TermController extends Controller
{
    
    public function create(){
        $term=Term::first();
        return view('pages.terms.create')->with('term',$term);
    }

    public function store(Request $request,$id){


        $post = Term::findorfail($id);
        if($post){
        $post->update($request->all());
        }else{
            $post->create($request->all());
        }
       
            return redirect()->to('/home');


        }
}
