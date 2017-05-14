<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;

class GatewaysController extends Controller
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
            $gateways = Gateway::where('serial', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $gateways = Gateway::paginate($perPage);
        }

        return view('gateways.index', compact('gateways'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('gateways.create');
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

        Gateway::create($requestData);

        Session::flash('flash_message', 'Gateway added!');

        return redirect('gateways');
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
        $gateway = Gateway::findOrFail($id);

        return view('gateways.show', compact('gateway'));
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
        $gateway = Gateway::findOrFail($id);

        return view('gateways.edit', compact('gateway'));
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

        $gateway = Gateway::findOrFail($id);
        $gateway->update($requestData);

        Session::flash('flash_message', 'Gateway updated!');

        return redirect('gateways');
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
        Gateway::destroy($id);

        Session::flash('flash_message', 'Gateway deleted!');

        return redirect('gateways');
    }

    // http://localhost:8000/report/123456/param?sensor_unit_serial=456789&sensor_index=1&type=1&value=34.4
    // /report/{gateway_serial}/param?sensor_unit_serial={}&sensor_index={}&type={}&value={}
    public function reportParametrised(Request $request, string $gatewaySerial)
    {
        $gateway = \App\Gateway::findOrFail($gatewaySerial);

        $sensorUnit = $gateway->sensorUnits()->where('serial','=',$request->get('sensor_unit_serial'))->firstOrFail();

        $sensor = $sensorUnit->sensors()->where('index','=',$request->get('sensor_index'))->firstOrFail();

        $raw_value = (float)$request->get('value');
        $value = $raw_value; // TODO: Offset, factor
        $sensor->measurements()->create(['at' => \Carbon\Carbon::now(), 'raw_value' => $raw_value, 'value' => $value]);

        return [$gateway, $sensorUnit, $sensor];
    }
}
