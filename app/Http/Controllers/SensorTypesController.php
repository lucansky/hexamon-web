<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SensorType;
use Illuminate\Http\Request;
use Session;

class SensorTypesController extends Controller
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
            $sensortypes = SensorType::where('name', 'LIKE', "%$keyword%")
				->orWhere('default_offset', 'LIKE', "%$keyword%")
				->orWhere('default_factor', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $sensortypes = SensorType::paginate($perPage);
        }

        return view('sensor-types.index', compact('sensortypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sensor-types.create');
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
        
        SensorType::create($requestData);

        Session::flash('flash_message', 'SensorType added!');

        return redirect('sensor-types');
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
        $sensortype = SensorType::findOrFail($id);

        return view('sensor-types.show', compact('sensortype'));
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
        $sensortype = SensorType::findOrFail($id);

        return view('sensor-types.edit', compact('sensortype'));
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
        
        $sensortype = SensorType::findOrFail($id);
        $sensortype->update($requestData);

        Session::flash('flash_message', 'SensorType updated!');

        return redirect('sensor-types');
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
        SensorType::destroy($id);

        Session::flash('flash_message', 'SensorType deleted!');

        return redirect('sensor-types');
    }
}
