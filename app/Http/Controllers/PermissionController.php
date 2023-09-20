<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request){
        $permissions = Permission::orderBy('created_at','desc')->get();
        return view('backend/manajemen_permissions.index',[
            'permissions'                   =>  $permissions,
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

        $simpan = Permission::create(['name' => $request->name]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Permission berhasil ditambahkan',
                'url'   =>  url('/manajemen_permission/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Permission gagal disimpan']);
        }
    }
    public function edit(Permission $permission){
        return $permission;
    }

    public function update(Request $request){
        $user = Permission::where('id',$request->permission_id)->first();
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

        $permission = Permission::where('id', $request->permission_id)->first();

        $update = $permission->update(['name' => $request->name]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Permission berhasil diubah',
                'url'   =>  url('/manajemen_permission/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Permission gagal diubah']);
        }
    }

    public function delete(Permission $permission){
        $delete = $permission->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Permission berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('manajemen_permission')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Permission gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
