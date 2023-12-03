<?php

namespace App\Http\Controllers;

use App\Models\PangkatGolongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class PangkatGolonganController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-pangkat-golongan')) {
            abort(403);
        }
        $nama_pangkat = $request->query('nama_pangkat');
        if (!empty($nama_pangkat)) {
            $pangkatgolongans = PangkatGolongan::where('nama_pangkat','LIKE','%'.$nama_pangkat.'%')
                                ->paginate(10);

        }else {
            $pangkatgolongans = PangkatGolongan::paginate(10);
        }

        return view('backend/pangkat_golongans.index',[
            'pangkatgolongans'         =>  $pangkatgolongans,
            'nama_pangkat'    =>  $nama_pangkat,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-pangkat-golongan')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        return view('backend/pangkat_golongans.create',compact('dosens'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-pangkat-golongan')) {
            abort(403);
        }
        $rules = [
            'nip'                         =>  'required|numeric',
            'nama_pangkat'                =>  'required',
            'golongan'                    =>  'required',
            'tmt_pangkat_golongan'        =>  'required|numeric',
        ];
        $text = [
            'nama_pangkat.required'             => 'nama Pangkat Golongan harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'golongan.required'                 => 'golongan harus diisi',
            'tmt_pangkat_golongan.required'     => 'tmt Pangkat Golongan harus diisi',
            'tmt_pangkat_golongan.numeric'      => 'tmt Pangkat Golongan harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = PangkatGolongan::create([
            'nip'                           =>  $request->nip,
            'nama_pangkat'                  =>  $request->nama_pangkat,
            'slug'                          =>  Str::slug($request->nama_pangkat),
            'golongan'                      =>  $request->golongan,
            'tmt_pangkat_golongan'          =>  $request->tmt_pangkat_golongan,
            'is_active'                     =>  1,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Pangkat Golongan.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Pangkat Golongan baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_pangkat_golongan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Pangkat Golongan gagal disimpan']);
        }
    }
    public function edit(PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('edit-pangkat-golongan')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        return view('backend.pangkat_golongans.edit',compact('dosens'),[
            'pangkatgolongan'   =>  $pangkatgolongan,
        ]);
    }

    public function update(Request $request, PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('update-pangkat-golongan')) {
            abort(403);
        }
        $rules = [
            'nama_pangkat'                =>  'required',
            'nip'                         =>  'required|numeric',
            'golongan'                    =>  'required',
            'tmt_pangkat_golongan'        =>  'required|numeric',
        ];
        $text = [
            'nama_pangkat.required'                   => 'nama Pangkat Golongan harus diisi',
            'nip.required'                            => 'Nip harus dipilih',
            'nip.numeric'                             => 'Nip harus berupa angka',
            'golongan.required'                       => 'golongan harus diisi',
            'tmt_pangkat_golongan.required'           => 'harga point fungsional harus diisi',
            'tmt_pangkat_golongan.numeric'            => 'harga point fungsional harus berupa angka',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $oldData = $pangkatgolongan->toArray();

        $update = $pangkatgolongan->update([
            'nip'                           =>  $request->nip,
            'nama_pangkat'                  =>  $request->nama_pangkat,
            'slug'                          =>  Str::slug($request->nama_pangkat),
            'golongan'                      =>  $request->golongan,
            'tmt_pangkat_golongan'          =>  $request->tmt_pangkat_golongan,
            'is_active'                     =>  1,
        ]);

        $newData = $pangkatgolongan->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($pangkatgolongan)
            ->event('updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has updated the Pangkat Golongan data.');

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Pangkat Golongan berhasil diubah',
                'url'   =>  url('/manajemen_pangkat_golongan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Pangkat Golongan anda gagal diubah']);
        }
    }
    public function setNonActive(PangkatGolongan $pangkatgolongan){

            $oldData = $pangkatgolongan->toArray();
            $update = $pangkatgolongan->update([
                'is_active' =>  0,
            ]);
            $newData = $pangkatgolongan->toArray();
            activity()
                ->causedBy(auth()->user()->id)
                ->performedOn($pangkatgolongan)
                ->event('deactivated')
                ->withProperties([
                    'old_data' => $oldData, // Data lama
                    'new_data' => $newData, // Data baru
                ])
                ->log(auth()->user()->nama_user . ' has deactivated the Pangkat Golongan data.');
                if ($update) {
                    $notification = array(
                        'message' => 'Yeay, data Pangkat Golongan berhasil dinonaktifkan',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('pangkat_golongan')->with($notification);
                }else {
                    $notification = array(
                        'message' => 'Ooopps, data Pangkat Golongan gagal dinonaktifkan',
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
                }
        }

    public function setActive(PangkatGolongan $pangkatgolongan){

        $oldData = $pangkatgolongan->toArray();
        $update = $pangkatgolongan->update([
            'is_active' =>  1,
        ]);
        $newData = $pangkatgolongan->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($pangkatgolongan)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the Pangkat Golongan data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, data Pangkat Golongan berhasil diaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('pangkat_golongan')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, data Pangkat Golongan gagal diaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
    public function delete(PangkatGolongan $pangkatgolongan){
        if (!Gate::allows('delete-pangkat-golongan')) {
            abort(403);
        }

        $oldData = $pangkatgolongan->toArray();
        $delete = $pangkatgolongan->delete();
        $newData = $pangkatgolongan->toArray();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($pangkatgolongan)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has deleted the Pangkat Golongan data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, Pangkat Golongan remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('pangkat_golongan')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, Pangkat Golongan remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
}
