<?php

namespace App\Modules\Role\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

use Log;
use DB;

class RoleController extends Controller
{

    public function __construct() {
        $_SESSION['MenuActive'] ='administration';
        $_SESSION['SubMenuActive'] = 'role';
    }
    public function index()
    {
        /*if(!auth()->user()->can('Role Management'))
            abort (403);*/
        
        $permissions = Permission::pluck('name','id');
        $roles = Role::get();

        return view("Role::index", compact('roles','permissions'));
    }
    
    public function store(Request $request)
    {
        // if(!auth()->user()->can('Role Management'))
        //     abort (403);
        
        $this->validate($request, [
            'name'=>'required|unique:roles,name',
            'permissions'=>'required|array',
            'permissions.*'=>'required|exists:permissions,id'
        ]);
        
        try{
            DB::begintransaction();
            $role = new Role();
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->save();
            
            $permissions = $request->input('permissions');
            
            if (count($permissions)) {
                $role->permissions()->attach($permissions);
            }
            DB::commit();
            return redirect()->back()->with('msg-success','Role Successfully Created');
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return redirect()->back()->withErrors(__('app.something_went_wrong'))->withInput();
        }
    }
    public function update($id,Request $request)
    {
        /*if(!auth()->user()->can('Role Management'))
            abort (403);*/
        
        $this->validate($request, [
            'permissions'=>'required|array',
            'permissions.*'=>'required|exists:permissions,id'
        ]);
        
        try{
            DB::begintransaction();
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $role = Role::findOrFail($id);
            
            $permissions = $request->input('permissions');

            if (count($permissions)) {
                $role->syncPermissions($permissions);
         }
         DB::commit();
         return redirect()->back()->with('msg-success','Role Successfully Updated');
     } catch (Exception $ex) {
        DB::rollback();
        Log::error($ex);
        return redirect()->back()->withErrors(__('app.something_went_wrong'))->withInput();
    }
}

public function destroy($id) {
    /*if(!auth()->user()->can('Role Management'))
        abort (403);*/

    try {
        Role::where('id', $id)->delete();
        return redirect()->back()->with("msg-success", "Role Successfully Deleted");
    } catch (Exception $ex) {
        Log::error($ex);
        return redirect()->back()->withErrors("Internal Server Error");
    }
}
}
