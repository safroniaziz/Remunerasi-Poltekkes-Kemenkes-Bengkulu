<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class UserController extends Controller
{
    public function index(Request $request){
        // if (!Gate::allows('read-user')) {
        //     abort(403);
        // }

        $users = User::orderBy('created_at','desc')->get();

         return view('backend/manajemen_data_users.index',[
            'users'                   =>  $users,
        ]);
    }

    public function store(Request $request){
        // if (!Gate::allows('store-r01-perkuliahan-teori')) {
        //     abort(403);
        // }
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
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new User.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, User remunerasi baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_user/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, User remunerasi gagal disimpan']);
        }
    }
    public function edit(User $user){
        // if (!Gate::allows('edit-r01-perkuliahan-teori')) {
        //     abort(403);
        // }
        return $user;
    }

    public function update(Request $request, User $user){
        // if (!Gate::allows('update-r01-perkuliahan-teori')) {
        //     abort(403);
        // }
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
        $data = User::where('id',$request->User_id_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'nama_user'        =>  $request->nama_user,
            'level_jurusan'    =>  $request->level_jurusan,
            'email'            =>  $request->email,
            'password'         =>  $request->password,
            'is_active'        =>  $request->is_active,
        ]);
        $newData = $data->toArray();

        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($data)
        ->event('updated')
        ->withProperties([
            'old_data' => $oldData, // Data lama
            'new_data' => $newData, // Data baru
        ])
        ->log(auth()->user()->nama_user . ' has updated the User data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, User remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_user/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, User remunerasi anda gagal diubah']);
        }
    }
    public function delete(User $user){
        // if (!Gate::allows('delete-r01-perkuliahan-teori')) {
        //     abort(403);
        // }

        $oldData = $user->toArray();
        $delete = $user->delete();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($user)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the Kelompok Rubrik data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, User remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('manajemen_data_user')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, User remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }

    public function active(User $user){

        $oldData = $user->toArray();
        $user->update([
            'is_active'   =>  1,
        ]);
        $newData = $user->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($user)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the user data.');
        $notification = array(
            'message' => 'Berhasil, status active berhasil diubah',
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
            ->log(auth()->user()->nama_user . ' has deactivated the user data.');
        $notification = array(
            'message' => 'Berhasil, status active berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
