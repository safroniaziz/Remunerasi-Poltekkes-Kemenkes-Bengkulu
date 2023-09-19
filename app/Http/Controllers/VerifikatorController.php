<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifikatorController extends Controller
{
    public function index(Request $request){
        $users = User::orderBy('created_at','desc')->get();
         return view('backend/manajemen_data_verifikators.index',[
            'users'                   =>  $users,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nama_user'      =>  'required',
            'email'          =>  'required',
            'level_jurusan'  =>  'required',
            'password'       =>  'required',
        ];
        $text = [
            'nama_user.required'     => 'Nama User harus diisi',
            'email.required'         => 'Email harus diisi',
            'level_jurusan.required' => 'Jurusan harus diisi',
            'password.required'      => 'Password harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = User::create([
            'nama_user'         =>  $request->nama_user,
            'level_jurusan'     =>  $request->level_jurusan,
            'email'             =>  $request->email,
            'password'          =>  $request->password,
            'is_active'         =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, User remunerasi baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_verifikator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, User remunerasi gagal disimpan']);
        }
    }
    public function edit(User $user){
        return $user;
    }

    public function update(Request $request, User $user){
        $rules = [
            'nama_user'      =>  'required',
            'email'          =>  'required',
            'level_jurusan'  =>  'required',
            'password'       =>  'required',
        ];
        $text = [
            'nama_user.required'     => 'Nama User harus diisi',
            'email.required'         => 'Email harus diisi',
            'level_jurusan.required' => 'Jurusan harus diisi',
            'password.required'      => 'Password harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = User::where('id',$request->User_id_edit)->update([
            'nama_user'        =>  $request->nama_user,
            'level_jurusan'    =>  $request->level_jurusan,
            'email'            =>  $request->email,
            'password'         =>  $request->password,
            'is_active'        =>  $request->is_active,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, User remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_verifikator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, User remunerasi anda gagal diubah']);
        }
    }
    public function delete(User $user){
        $delete = $user->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, User remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('manajemen_data_verifikator')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, User remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function active(User $user){
        $user->update([
            'is_active'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status active berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function nonactive(User $user){
        $user->update([
            'is_active'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status active berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
