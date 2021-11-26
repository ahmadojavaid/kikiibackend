<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use DataTables;
use Response;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $data = Event::select(['id','name','description','datetime','cover_pic']);
            return Datatables::of($data)
            
                // return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
                // return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
            ->addColumn('cover_pic', function ($data) { 
                $url=$data->cover_pic;
                 
                return '<img src='.$url.' border="0" width="50" class="img-rounded" align="center" />'; 
                
            })
            ->addColumn('action', function($data){
                           
                $editUrl = route('events.edit' , $data->id);
                // $deleteUrl = url('moderator/'.$data->id);
                $btn = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTodo">Delete</a>';

                
        
                // $btn = ' <a href="'.$deleteUrl.'" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete_user">Delete</a>';

                return $btn;
        
                
         })
         ->rawColumns(['action','cover_pic'])
         ->make(true);

        }
                    
        return view('pages.events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();

        $event->name = $request->name;
        $event->description = $request->description;
        $event->datetime = $request->datetime;
        $event->cover_pic = $request->cover_pic;
        $event->user_id = Auth()->user()->id;
        $event->save();


        return redirect()->back()->with('success', 'Event Created!');
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
        $data['event'] = Event::find($id);
        //dd($data['event']);
        return view('pages.events.edit' ,$data);
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
        $event = Event::find($id);
        if(isset($request->name))
            $event->name = $request->name;
        if(isset($request->description))
            $event->description = $request->description;
        if(isset($request->datetime))
            $event->datetime = $request->datetime;
        if(isset($request->cover_pic))
            $event->cover_pic = $request->cover_pic;

        $event->save();


        return redirect()->back()->with('success', 'Event Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $event = Event::where('id', $id)->delete();
 
        return redirect('/events');
    }
}
