<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;


class AdministratorController extends Controller
{
    public function index(Request $request){
        $administrators = User::administrator()->orderBy('created_at','desc')->get();
        return view('backend/manajemen_data_administrators.index',[
            'administrators'                   =>  $administrators,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nama_user'      =>  'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'password_confirmation' => 'required|same:password', // Ini adalah validasi konfirmasi password
            'is_active' => 'required|boolean',
        ];

        $text = [
            'nama_user.required'           => 'Nama User harus diisi',
            'email.required'               => 'Email harus diisi',
            'password.required'            => 'Password harus diisi',
            'password.min'                 => 'Password harus memiliki setidaknya :min karakter',
            'password.regex'               => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus',
            'password_confirmation.required' => 'Konfirmasi Password harus diisi',
            'password_confirmation.same'   => 'Konfirmasi Password harus sama dengan Password',
            'is_active.required'           => 'Status administrator harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = User::create([
            'nama_user'         =>  $request->nama_user,
            'email'             =>  $request->email,
            'password'          =>  Hash::make($request->password),
            'is_active'         =>  $request->is_active,
        ]);

        $administratorRole = Role::where('name', 'administrator')->first();
        $simpan->assignRole($administratorRole);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->name . ' has created a new Administrator.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, administrator remunerasi berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_administrator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, administrator remunerasi gagal disimpan']);
        }
    }
    public function edit(User $administrator){
        return $administrator;
    }

    public function update(Request $request){
        $administrator = User::where('id',$request->administrator_id)->first();
        $rules = [
            'nama_user'      =>  'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($administrator->id), // $administrator adalah instance dari model User yang sedang diedit
            ],
            'is_active' => 'required|boolean',
        ];

        $text = [
            'nama_user.required'           => 'Nama User harus diisi',
            'email.required'               => 'Email harus diisi',
            'is_active.required'           => 'Status administrator harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $administrator->update([
            'nama_user'        =>  $request->nama_user,
            'email'            =>  $request->email,
            'is_active'        =>  $request->is_active,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, administrator remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_administrator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, administrator remunerasi gagal diubah']);
        }
    }

    public function delete(User $administrator){
        $delete = $administrator->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, administrator berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('manajemen_data_administrator')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, administrator gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function active(User $administrator){
        $administrator->update([
            'is_active'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, administrator berhasil diaktifkan',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function nonactive(User $administrator){
        $administrator->update([
            'is_active'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, administrator berhasil dinonaktifkan',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ubahPassword(Request $request){
        $rules = [
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'password_confirmation' => 'required|same:password', // Ini adalah validasi konfirmasi password
        ];

        $text = [
            'password.required'            => 'Password harus diisi',
            'password.min'                 => 'Password harus memiliki setidaknya :min karakter',
            'password.regex'               => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus',
            'password_confirmation.required' => 'Konfirmasi Password harus diisi',
            'password_confirmation.same'   => 'Konfirmasi Password harus sama dengan Password',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $ubahPassword = User::where('id',$request->id)->update([
            'password'  =>  Hash::make($request->password),
        ]);

        if ($ubahPassword) {
            return response()->json([
                'text'  =>  'Yeay, Password administrator berhasil diubah',
                'url'   =>  url('/manajemen_data_administrator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Password administrator gagal diubah']);
        }
    }
}
