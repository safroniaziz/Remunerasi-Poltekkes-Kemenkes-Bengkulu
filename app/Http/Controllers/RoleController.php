<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request){
        $roles = Role::with('permissions')->get();
        return view('backend/manajemen_roles.index',[
            'roles'                   =>  $roles,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'name'      =>  'required',
        ];
        
        $text = [
            'name.required'           => 'Nama User harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Role::create(['name' => $request->name]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Role berhasil ditambahkan',
                'url'   =>  url('/manajemen_role/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Role gagal disimpan']);
        }
    }
    public function edit(Role $role){
        return $role;
    }

    public function update(Request $request){
        $user = Role::where('id',$request->role_id)->first();
        $rules = [
            'name'      =>  'required',
        ];
        
        $text = [
            'name.required'           => 'Nama User harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $role = Role::where('id', $request->role_id)->first();

        $update = $role->update(['name' => $request->name]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Role berhasil diubah',
                'url'   =>  url('/manajemen_role/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Role gagal diubah']);
        }
    }

    public function delete(Role $role){
        $delete = $role->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Role berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('manajemen_role')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Role gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function detail(Role $role){
        $role = Role::with('permissions')->where('id',$role->id)->first();
        $unassignedPermissions = Permission::whereDoesntHave('roles', function ($query) use ($role) {
            $query->where('id', $role->id);
        })->get();
        return view('backend/manajemen_roles.detail',[
            'role'                   =>  $role,
            'unassignedPermissions'                   =>  $unassignedPermissions,
        ]);
    }

    public function assign(Request $request, Role $role){
        $permission = Permission::find($request->permission_id);
        $role->givePermissionTo($permission);
        $notification = array(
            'message' => 'Yeay, Assign permission ke role berhasil',
            'alert-type' => 'success'
        );
        return redirect()->route('manajemen_role.detail',[$role->id])->with($notification);
    }

    public function revoke(Role $role, Permission $permission){
        $role->revokePermissionTo($permission);
        $notification = array(
            'message' => 'Permission berhasil dicabut dari role',
            'alert-type' => 'success'
        );
    
        return redirect()->route('manajemen_role.detail',[$role->id])->with($notification);
    }
}
