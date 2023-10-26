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

class VerifikatorController extends Controller
{
    public function index(Request $request){
        $users = User::verifikator()->orderBy('created_at','desc')->get();
        $fakultases = DB::table('prodis')
                    ->select('kodefak', 'nmfak')
                    ->groupBy('kodefak', 'nmfak') // Menambahkan kolom nmfak ke GROUP BY
                    ->get();
                    activity()
                    ->causedBy(auth()->user()->id)
                    ->event('accessed')
                    ->log(auth()->user()->name . ' has accessed the Verifikator value page.');
        return view('backend/manajemen_data_verifikators.index',[
            'users'                   =>  $users,
            'fakultases'                   =>  $fakultases,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'nama_user'      =>  'required',
            'kodefak'  =>  'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'password_confirmation' => 'required|same:password', // Ini adalah validasi konfirmasi password
            'is_active' => 'required|boolean',
        ];

        $text = [
            'nama_user.required'           => 'Nama User harus diisi',
            'email.required'               => 'Email harus diisi',
            'kodefak.required'       => 'Jurusan harus diisi',
            'password.required'            => 'Password harus diisi',
            'password.min'                 => 'Password harus memiliki setidaknya :min karakter',
            'password.regex'               => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus',
            'password_confirmation.required' => 'Konfirmasi Password harus diisi',
            'password_confirmation.same'   => 'Konfirmasi Password harus sama dengan Password',
            'is_active.required'           => 'Status Verifikator harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = User::create([
            'nama_user'         =>  $request->nama_user,
            'kodefak'     =>  $request->kodefak,
            'email'             =>  $request->email,
            'password'          =>  Hash::make($request->password),
            'is_active'         =>  $request->is_active,
        ]);

        $verifikatorRole = Role::where('name', 'verifikator')->first();
        $simpan->assignRole($verifikatorRole);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->name . ' has created a new Verifikator.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Verifikator remunerasi berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_verifikator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Verifikator remunerasi gagal disimpan']);
        }
    }
    public function edit(User $user){
        return $user;
    }

    public function update(Request $request){
        $user = User::where('id',$request->verifikator_id)->first();
        $rules = [
            'nama_user'      =>  'required',
            'kodefak'  =>  'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id), // $user adalah instance dari model User yang sedang diedit
            ],
            'is_active' => 'required|boolean',
        ];

        $text = [
            'nama_user.required'           => 'Nama User harus diisi',
            'email.required'               => 'Email harus diisi',
            'kodefak.required'              => 'Jurusan harus diisi',
            'is_active.required'           => 'Status Verifikator harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $oldData = $user->toArray();

        $update = $user->update([
            'nama_user'        =>  $request->nama_user,
            'kodefak'    =>  $request->kodefak,
            'email'            =>  $request->email,
            'is_active'        =>  $request->is_active,
        ]);

        $newData = $user->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($user)
            ->event('updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has updated the ewmp data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Verifikator remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_verifikator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Verifikator remunerasi gagal diubah']);
        }
    }

    public function delete(User $user){
        $delete = $user->delete();
        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Verifikator berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('manajemen_data_verifikator')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Verifikator gagal dihapus',
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
            'message' => 'Berhasil, verifikator berhasil diaktifkan',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function nonactive(User $user){
        $oldData = $user->toArray();
        $user->update([
            'is_active'   =>  0,
        ]);
        $newData = $user->toArray();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($user)
            ->event('deactivated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has deactivated the verifikator data.');
        $notification = array(
            'message' => 'Berhasil, verifikator berhasil dinonaktifkan',
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

        $data = User::where('id',$request->id)->first();
        $oldData = $data->toArray();

        $ubahPassword = $data->update([
            'password'  =>  Hash::make($request->password),
        ]);
        $update = $data->update([
            'is_active' =>  0,
        ]);
        $newData = $data->toArray();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($data)
            ->event('deactivated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has deactivated the ewmp data.');
            if ($ubahPassword) {
                return response()->json([
                    'text'  =>  'Yeay, Password verifikator berhasil diubah',
                    'url'   =>  url('/manajemen_data_verifikator/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Password verifikator gagal diubah']);
            }
    }
}
