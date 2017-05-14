<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;

class SensorsController extends Controller
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
            $sensors = Sensor::where('sensor_unit_serial', 'LIKE', "%$keyword%")
				->orWhere('index', 'LIKE', "%$keyword%")
				->orWhere('sensor_type_id', 'LIKE', "%$keyword%")
				->orWhere('offset', 'LIKE', "%$keyword%")
				->orWhere('factor', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $sensors = Sensor::paginate($perPage);
        }

        return view('sensors.index', compact('sensors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sensors.create');
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
        
        Sensor::create($requestData);

        Session::flash('flash_message', 'Sensor added!');

        return redirect('sensors');
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
        // for($i = 0; $i < 10000; $i++) { $v = (50+rand(1,15));$m = new \App\Measurement(['at' => $date->addHours(1), 'value' => $v, 'raw_value' => $v, 'sensor_id' => 1]); $m->save(); }
        $sensor = Sensor::findOrFail($id);
        $measurements = $sensor->measurements;

        return view('sensors.show', compact('sensor', 'measurements'));
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
        $sensor = Sensor::findOrFail($id);

        return view('sensors.edit', compact('sensor'));
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
        
        $sensor = Sensor::findOrFail($id);
        $sensor->update($requestData);

        Session::flash('flash_message', 'Sensor updated!');

        return redirect('sensors');
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
        Sensor::destroy($id);

        Session::flash('flash_message', 'Sensor deleted!');

        return redirect('sensors');
    }

    public function tare($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensor->offset = $sensor->measurements()->orderBy('at', 'DESC')->firstOrFail()->raw_value;
        $sensor->save();

        return redirect('sensors');
    }

    public function calibrate($id, Request $request)
    {
        $sensor = Sensor::findOrFail($id);
        $empty_weight = $sensor->offset;
        $weight_with_reference = (float)$sensor->measurements()->orderBy('at', 'DESC')->firstOrFail()->raw_value;
        $grams = (float)$request->input('known_weight');

        $sensor->factor = ($weight_with_reference - $empty_weight)/$grams;
        $sensor->save();

        return redirect('sensors');
    }

    public function data($id, Request $request)
    {
        $sensor = Sensor::findOrFail($id);
        $measurements = $sensor->measurements;

        $data = $measurements->map(function ($m) { return [$m->at->timestamp*1000, (double) $m->value]; });

        return response()
            ->json($data)
            ->withCallback($request->input('callback'));
    }

    // http://localhost:8000/sensors/report/raw/{can_id}/{can_data}
    public function reportRaw(Request $request, string $canId, string $canMessage)
    {
        $sensorUnitSerial = $canId;

        // 8-bits
        $sensorIndex = hexdec(substr($canMessage, 0, 2));
        // 8-bits
        $sensorType  = hexdec(substr($canMessage, 2, 2));

        // 32-bits
        $data = hexdec(substr($canMessage, 4, 8));

        $sensor = \App\Sensor::where('sensor_unit_serial', '=', $sensorUnitSerial)->where('index', '=', $sensorIndex)->firstOrFail();
        //$sensorUnit = $gateway->sensorUnits()->where('serial', '=', $sensorUnitSerial)->firstOrFail();

        //$sensor = $sensorUnit->sensors()->where('index', '=', $sensorIndex)->firstOrFail();

        $raw_value = (double)$data;
        $value = ($raw_value - $sensor->offset) / $sensor->factor; // TODO: Offset, factor

        Log::info($value);

        $sensor->measurements()->create(['at' => \Carbon\Carbon::now(), 'raw_value' => $raw_value, 'value' => $value]);

        return [$sensorUnitSerial, $sensorIndex, $sensorType, $data];
    }

}
