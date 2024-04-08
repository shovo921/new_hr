<?php

namespace App\Modules\LeaveRmBmZone\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\LeaveRmBmZone\Models\Zone;
use Illuminate\Http\Request;


use Carbon\Carbon;

class ZoneController extends Controller
{
	public function __construct(){
		$_SESSION["MenuActive"] = "transfer";
	}

	/**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$_SESSION['SubMenuActive'] = 'zone';
        $data['zone']  = Zone::all();
		return view('LeaveRmBmZone::Zone/list',compact('data'));

	}

    public function createOrEdit($id)
    {
        $data['zone'] = empty($id) ? null : Zone::findOrFail($id);
        return view('LeaveRmBmZone::Zone/createOrUpdate', compact('data'));
    }

    public function storeOrUpdate(Request $request)
    {

        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'zone_name' => 'required',
                'zone_address' => 'required',
                'status' => 'required'
            ));
            $data=[
                'name'=>$request->zone_name,
                'address'=>$request->zone_address,
                'status'=>$request->status
            ];

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $zone = new Zone();
            if (empty($request->id)) {
                $zone->fill($data)->save();
                return Redirect()->back()->with('msg-success', 'Zone Successfully Created');
            } else {

                $zone->findOrFail($request->id)->update($data);
                return Redirect()->back()->with('msg-success', 'Zone Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('Zone-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            Zone::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Bill Type Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('BillsTypeController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }
}
