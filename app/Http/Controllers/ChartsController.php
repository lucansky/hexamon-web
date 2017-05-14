<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Chart;
use Illuminate\Http\Request;
use Session;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    // \App\Sensor::find(1)->measurements->map(function($m) {return (new \App\Measurement(['sensor_id' => 2, 'at' => $m->at, 'value' => 40+rand(0,5), 'raw_value' => 40]))->save();})
    public function index(Request $request)
    {
        $charts = Chart::all();

        $sensor_categories = $charts->groupBy('category_name')->map(function($charts, $category_name) {
            return $charts->map(function($chart) {
                return ['sensor_id' => $chart->sensor_id, 'sensor_comment' => $chart->sensor->comment];
            });
        });

        return view('charts.index', compact('charts','sensor_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('charts.create');
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
        
        Chart::create($requestData);

        Session::flash('flash_message', 'Chart added!');

        return redirect('charts');
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
        $chart = Chart::findOrFail($id);

        return view('charts.show', compact('chart'));
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
        $chart = Chart::findOrFail($id);

        return view('charts.edit', compact('chart'));
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
        
        $chart = Chart::findOrFail($id);
        $chart->update($requestData);

        Session::flash('flash_message', 'Chart updated!');

        return redirect('charts');
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
        Chart::destroy($id);

        Session::flash('flash_message', 'Chart deleted!');

        return redirect('charts');
    }
}
