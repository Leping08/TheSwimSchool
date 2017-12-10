<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Done in dashboard
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Done in dashboard
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|digits:5',
            'phoneNumber' => 'required|string'
        ]);

        $newLocation = Location::create($request->all());
        Log::info("$newLocation->name has been created. Location ID: $newLocation->id");
        session()->flash('success', "$newLocation->name was created");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $location = Location::find($location->id);
        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $location = Location::find($location->id);
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|digits:5',
            'phoneNumber' => 'required|string'
        ]);

        Location::find($location->id)->update($request->all());
        Log::info("$location->name has been updated. Location ID: $location->id");
        session()->flash('success_msg', "$location->name has been updated");
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location = Location::find($location->id);
        $locations = $location->Lessons()->get();
        if($locations->isEmpty()){
            session()->flash('success', "$location->name was deleted.");
            Log::info("$location->name was deleted. Location ID: $location->id");
            $location->delete();
            return redirect('/dashboard');
        }else{
            Log::info("$location->name can not be deleted. It has lessons associated with it. Location ID: $location->id");
            session()->flash('warning', "$location->name can not be deleted. It has lessons associated with it.");
            return back();
        }
    }
}
