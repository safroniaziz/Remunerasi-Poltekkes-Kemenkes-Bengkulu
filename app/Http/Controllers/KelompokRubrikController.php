<?php

namespace App\Http\Controllers;
use App\Models\KelompokRubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class KelompokRubrikController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-kelompok-rubrik')) {
            abort(403);
        }
        $kelompokrubriks = KelompokRubrik::orderBy('created_at','desc')->get();

        return view('backend/kelompok_rubriks.index',[
            'kelompokrubriks'         =>  $kelompokrubriks,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-kelompok-rubrik')) {
            abort(403);
        }
        return view('backend/kelompok_rubriks.create');
    }

    public function store(Request $request){
        if (!Gate::allows('store-kelompok-rubrik')) {
            abort(403);
        }
        $rules = [
            'nama_kelompok_rubrik'       =>  'required',
        ];
        $text = [
            'nama_kelompok_rubrik.required'  => 'Nama Kelompok Rubrik harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = KelompokRubrik::create([
            'nama_kelompok_rubrik'          =>  $request->nama_kelompok_rubrik,
            'slug'                          =>  Str::slug($request->nama_kelompok_rubrik),
            'is_active'                     =>  1,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Kelompok Rubrik.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Kelompok Rubrik baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_kelompok_rubrik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Kelompok Rubrik gagal disimpan']);
        }
    }
    public function edit(KelompokRubrik $kelompokrubrik){
        if (!Gate::allows('edit-kelompok-rubrik')) {
            abort(403);
        }
        return $kelompokrubrik;
    }

    public function update(Request $request, KelompokRubrik $kelompokrubrik){
        if (!Gate::allows('update-kelompok-rubrik')) {
            abort(403);
        }
        $rules = [
            'nama_kelompok_rubrik_edit'       =>  'required',
        ];
        $text = [
            'nama_kelompok_rubrik_edit.required'          => 'Nama Kelompok Rubrik harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $data = KelompokRubrik::where('id',$request->kelompok_rubrik_id_edit)->first();
        $oldData = $data->toArray();

        $update = $data->update([
            'nama_kelompok_rubrik'          =>  $request->nama_kelompok_rubrik_edit,
            'slug'                          =>  Str::slug($request->nama_kelompok_rubrik_edit),
            'is_active'                     =>  1,
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
        ->log(auth()->user()->nama_user . ' has updated the Kelompok Rubrik data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Kelompok Rubrik berhasil diubah',
                'url'   =>  url('/manajemen_kelompok_rubrik/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Kelompok Rubrik anda gagal diubah']);
        }
    }
    public function setNonActive(KelompokRubrik $kelompokrubrik){

        $oldData = $kelompokrubrik->toArray();

        $update = $kelompokrubrik->update([
            'is_active' =>  0,
        ]);

        $newData = $kelompokrubrik->toArray();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($kelompokrubrik)
            ->event('deactivated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has deactivated the Kelompok Rubrik data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, data Kelompok Rubrik berhasil dinonaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('kelompok_rubrik')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, data kelompok rubrik gagal dinonaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }

    public function setActive(KelompokRubrik $kelompokrubrik){

        $oldData = $kelompokrubrik->toArray();
        $update = $kelompokrubrik->update([
            'is_active' =>  1,
        ]);
        $newData = $kelompokrubrik->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($kelompokrubrik)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the Kelompok Rubrik data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, data Kelompok Rubrik berhasil diaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('kelompok_rubrik')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, data Kelompok Rubrik gagal diaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
    public function delete(KelompokRubrik $kelompokrubrik){
        if (!Gate::allows('delete-kelompok-rubrik')) {
            abort(403);
        }

        $oldData = $kelompokrubrik->toArray();
        $delete = $kelompokrubrik->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($kelompokrubrik)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the Kelompok Rubrik data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, Kelompok rubrik remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('kelompok_rubrik')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, kelompok rubrik remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
}
