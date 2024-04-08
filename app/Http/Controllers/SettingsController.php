<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Setting;
use App\Http\Traits\FileProcessTrait;

class SettingsController extends Controller {

    use FileProcessTrait;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $settings = Setting::pluck('value', 'key');

        return view('settings', compact('settings'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'off_day' => 'required',
            'service_charge' => 'required|numeric|min:0',
            'map' => 'sometimes|nullable|mimes:jpeg,jpg,png'
        ]);
        try {
            if ($request->hasFile('map')) {
                $map = $this->processSingle($request, 'map', 'image_gallery');
            } else {
                $map = null;
            }
            $data = [
                [
                    'key' => 'off_day',
                    'value' => $request->off_day
                ],
                [
                    'key' => 'service_charge',
                    'value' => $request->service_charge
                ],
                [
                    'key' => 'map',
                    'value' => $map
                ],
            ];

            foreach ($data as $d) {
                if (Setting::where('key', $d['key'])->exists()) {
                    if ($d['key'] == 'map') {
                        if (!is_null($map)) {
                            Setting::where('key', $d['key'])->update($d);
                        }
                    } else {
                        Setting::where('key', $d['key'])->update($d);
                    }
                } else {
                    Setting::create($d);
                }
            }


            return redirect()->back()->with('success', "Setting Updated");
        } catch (Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Something went wrong")->withInput();
        }
    }

}
