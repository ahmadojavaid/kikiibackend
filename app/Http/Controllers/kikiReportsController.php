<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kikiReport;

class kikiReportsController extends Controller
{
    public function index(){
        $reports=kikiReport::with('user')->get();
        //dd($reports);
        return view('pages.reports.index')->with('reports',$reports);
    }

    public function destroy($id)
    {
        $contact = kikiReport::find($id);
        $contact->delete();

        return redirect('/reports')->with('success', 'Report deleted!');
    }
}
