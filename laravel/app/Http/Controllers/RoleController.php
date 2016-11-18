<?php

namespace App\Http\Controllers;

use App\Module;
use App\RoleModule;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

use App\Http\Requests;
use PhpParser\Node\Expr\AssignOp\Mod;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('read:roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role', [
            'roles' => UserRole::where('title', '<>', 'User')
                ->where('title', '<>', 'Super Admin')->get(),
            'modules' => Module::all(),
            'right' => Auth::user()->role->modules()->where('url', 'roles')->first()->pivot,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:user_roles',
        ]);

        DB::transaction(function () use ($request) {
            $role = UserRole::create([
                'title' => $request->title,
            ]);

            $modules = Module::all();
            foreach ($modules as $module){
                RoleModule::create([
                    'role_id' => $role->id,
                    'module_id' => $module->id,
                    'can_read' => $request->has('read'.$module->id) ? true : false,
                    'can_write' => $request->has('write'.$module->id) ? true : false,
                ]);
            }
        });

        return redirect('admin/roles')->with('status', 'New User Role has been Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('modals.permission', [
           'role' => UserRole::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        UserRole::find($id)->update([
            'title' => $request->title
        ]);

        return 0;
    }

    public function setPermission(Request $request, $id){
        $permissions = RoleModule::where('role_id', $id)->get();
        foreach ($permissions as $permission){
            //UPDATE CAN READ
            if($request->has('read'.$permission->id)){
                $permission->update([
                   'can_read' => true
                ]);
            }else{
                $permission->update([
                    'can_read' => false
                ]);
            }

            //UPDATE CAN WRITE PERMISSION
            if($request->has('write'.$permission->id)){
                $permission->update([
                    'can_write' => true
                ]);
            }else{
                $permission->update([
                    'can_write' => false
                ]);
            }
        }
        return redirect('admin/roles/')->with('status', $permission->title .' privileges has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $role = UserRole::find($id);
            foreach ($role->users as $user){
                $user->update([
                    'role_id' => UserRole::where('title', 'User')->first()->id
                ]);
            }
            $role->delete();

            return redirect('admin/roles/')->with('status', 'A User Role has Been removed!');
        });


    }
}
