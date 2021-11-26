<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserMatch;

class MatchesController extends Controller
{
    public function index(){
        $match=UserMatch::with('usermatch','likes')->get();

        // dd($match->likes->name);
        // dd($userReport);
        return view('pages.matches.index')->with('match',$match);
    }

    public function destroy($id){
        $contact = UserMatch::find($id);
        $contact->delete();
    
        return redirect('/user/report')->with('success', 'Contact deleted!');
    }
        
}
