<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;


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
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Permission.');
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
        $oldData = $permission->toArray();

        $update = $permission->update(['name' => $request->name]);

        $newData = $permission->toArray();

        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($data)
        ->event('updated')
        ->withProperties([
            'old_data' => $oldData, // Data lama
            'new_data' => $newData, // Data baru
        ])
        ->log(auth()->user()->nama_user . ' has updated the Permission data.');
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

        $oldData = $kelompokrubrik->toArray();
        $delete = $permission->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($kelompokrubrik)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the Permission data.');
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
