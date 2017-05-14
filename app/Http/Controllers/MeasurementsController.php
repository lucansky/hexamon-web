<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Measurement;
use Illuminate\Http\Request;
use Session;

class MeasurementsController extends Controller
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
            $measurements = Measurement::where('sensor_id', 'LIKE', "%$keyword%")
				->orWhere('at', 'LIKE', "%$keyword%")
				->orWhere('value', 'LIKE', "%$keyword%")
				->orWhere('raw_value', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $measurements = Measurement::paginate($perPage);
        }

        return view('measurements.index', compact('measurements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('measurements.create');
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
        
        Measurement::create($requestData);

        Session::flash('flash_message', 'Measurement added!');

        return redirect('measurements');
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
        $measurement = Measurement::findOrFail($id);

        return view('measurements.show', compact('measurement'));
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
        $measurement = Measurement::findOrFail($id);

        return view('measurements.edit', compact('measurement'));
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
        
        $measurement = Measurement::findOrFail($id);
        $measurement->update($requestData);

        Session::flash('flash_message', 'Measurement updated!');

        return redirect('measurements');
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
        Measurement::destroy($id);

        Session::flash('flash_message', 'Measurement deleted!');

        return redirect('measurements');
    }
}
