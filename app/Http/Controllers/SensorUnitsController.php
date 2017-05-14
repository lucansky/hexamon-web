<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SensorUnit;
use Illuminate\Http\Request;
use Session;

class SensorUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $sensorunits = SensorUnit::where('serial', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
				->orWhere('last_seen', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $sensorunits = SensorUnit::paginate($perPage);
        }

        return view('sensor-units.index', compact('sensorunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sensor-units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        
        SensorUnit::create($requestData);

        Session::flash('flash_message', 'SensorUnit added!');

        return redirect('sensor-units');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $sensorunit = SensorUnit::findOrFail($id);

        return view('sensor-units.show', compact('sensorunit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $sensorunit = SensorUnit::findOrFail($id);

        return view('sensor-units.edit', compact('sensorunit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $sensorunit = SensorUnit::findOrFail($id);
        $sensorunit->update($requestData);

        Session::flash('flash_message', 'SensorUnit updated!');

        return redirect('sensor-units');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        SensorUnit::destroy($id);

        Session::flash('flash_message', 'SensorUnit deleted!');

        return redirect('sensor-units');
    }
}
