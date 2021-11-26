<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\AdminSetting;

class AdminSettingController extends Controller
{
    public function index(){
        
        return view('pages.settings.create');
        
    }

    public function saveCategory(Request $request){
        // dd($request->all());

        $category = AdminSetting::create([
            'key' => $request->get('key'),
            
           ]);

           return redirect('/home');
    }

    public function addvalue(){
        $cat=AdminSetting::get();  
        return view('pages.settings.addvalue')->with('cat',$cat);
    }

    public function add(Request $request){
        

        $admin=AdminSetting::where('id',$request->category)
        ->update(['value'=>$request->value]);

        return redirect('/home');

    }
    public function getValuePopulate(){

        $key_id = request()->value;

        $model = AdminSetting::where("id",$key_id)->first();

       return response()->json($model->value_attr);
    }
}
