<?php

namespace App\Http\Controllers;

use App\Swimmer;
use App\Lesson;
use Illuminate\Http\Request;

class SwimmerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check to see if any swimmers are singed up
        $swimmers = Swimmer::orderBy('id', 'desc')->get();
        $count = $swimmers->count();
        if($count > 0){
            //return all the swimmers
            return view('swimmers.list', compact('swimmers'));
        }else{
            //return the no swimmers view
            return view('swimmers.listNoCount', compact('swimmers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $swimmer = Swimmer::findOrFail($id);
        return view('swimmers.show', compact('swimmer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Swimmer $swimmer, $id)
    {
        $swimmer = Swimmer::findOrFail($id);
        return view('swimmers.edit', compact('swimmer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //valadate data
        $this->validate(request(), [
            'name' => 'required|string|max:191',
            'age' => 'required|digits_between:1,3',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'required|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20'
        ]);

        $swimmer = Swimmer::findOrFail($id);
        $swimmer->name = $request->input('name');
        $swimmer->age = $request->input('age');
        $swimmer->parent = $request->input('parent');
        $swimmer->street = $request->input('street');
        $swimmer->city = $request->input('city');
        $swimmer->state = $request->input('state');
        $swimmer->zip = $request->input('zip');
        $swimmer->phone = $request->input('phone');
        $swimmer->email = $request->input('email');
        $swimmer->emergencyName = $request->input('emergencyName');
        $swimmer->emergencyRelationship = $request->input('emergencyRelationship');
        $swimmer->emergencyPhone = $request->input('emergencyPhone');
        $swimmer->notes = $request->input('notes');

        $swimmer->update();

        session()->flash('info', $swimmer->name.' has been updated.');

        return redirect('/swimmers/'.$swimmer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Swimmer $swimmer, $id)
    {
        $swimmerToDelete = Swimmer::findOrFail($id);
        if($swimmerToDelete){
            $swimmerToDelete->delete();
            session()->flash('success', $swimmerToDelete->name.' has been deleted.');
        }
        return redirect('/swimmers');
    }
}
