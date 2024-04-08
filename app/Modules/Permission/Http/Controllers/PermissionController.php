<?php

namespace App\Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

use DB;

class PermissionController extends Controller
{

	public function __construct(){
		$_SESSION['MenuActive'] ='administration';
		$_SESSION['SubMenuActive'] = 'permission';
	}

	/**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$PermissionList = Permission::all();
		return view('Permission::index',compact('PermissionList'));
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{
		return view('Permission::create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$inputs = $request->all();

    	try {
            DB::beginTransaction();
            // Reset cached roles and permissions
            //app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // create permissions
            Permission::create($inputs);

            return Redirect('permission') -> with('msg-success', 'Permission Successfully Created');
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            // something went wrong
            return Redirect() -> route('permission.index') -> with('msg-error', $e->getMessage());
        }
    }


    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$Permission = Permission::findOrFail($id);

    	return view('Permission::edit',compact('Permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$Permission = Permission::findOrFail($id);
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, Permission::$rules);

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$Permission->fill($inputs)->save();

    	return Redirect('permission') -> with('msg-success', 'Permission Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try {
    		Permission::destroy($id);
    		return Redirect() -> route('permission.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('permission.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
