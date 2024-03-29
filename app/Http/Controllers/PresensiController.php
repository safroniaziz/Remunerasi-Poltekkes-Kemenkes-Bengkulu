<?php

namespace App\Http\Controllers;
use App\Models\Presensi;
use App\Models\Pegawai;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;


class PresensiController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-presensi')) {
            abort(403);
        }
        $presensis = Presensi::orderBy('created_at','desc')->get();
        activity()
        ->causedBy(auth()->user()->id)
        ->event('accessed')
        ->log(auth()->user()->name . ' has accessed the Presensi value page.');
        return view('backend/presensis.index',[
            'presensis'         =>  $presensis,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-presensi')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend/presensis.create',compact('dosens','periodes'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-presensi')) {
            abort(403);
        }
        $rules = [
            'periode_id'       =>  'required',
            'nip'              =>  'required',
            'jumlah_kehadiran' =>  'required',
        ];
        $text = [
            'periode_id.required'       => 'periode harus diisi',
            'nip.required'              => 'Nip harus dipilih',
            'nip.numeric'               => 'Nip harus berupa angka',
            'jumlah_kehadiran.required' => 'jumlah kehadiran harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Presensi::create([
            'periode_id'          =>  $request->periode_id,
            'nip'                 =>  $request->nip,
            'jumlah_kehadiran'    =>  $request->jumlah_kehadiran,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->name . ' has created a new Presensi.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Presensi baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_presensi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Presensi gagal disimpan']);
        }
    }
    public function edit(Presensi $presensi){
        if (!Gate::allows('edit-presensi')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend.presensis.edit',compact('dosens','periodes'),[
            'presensi'   =>  $presensi,
        ]);
    }

    public function update(Request $request, Presensi $presensi){
        if (!Gate::allows('update-presensi')) {
            abort(403);
        }
        $rules = [
            'periode_id'       =>  'required',
        ];
        $text = [
            'periode_id.required'   => 'Periode harus diisi',
            'nip.required'          => 'Nip harus dipilih',
            'nip.numeric'           => 'Nip harus berupa angka',
            'periode_id.required'   => 'Jumlah Kehadiran harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = Presensi::where('id',$request->periode_id_edit)->update([
            'periode_id'          =>  $request->periode_id,
            'nip'                 =>  $request->nip,
            'jumlah_kehadiran'    =>  $request->jumlah_kehadiran,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Presensi berhasil diubah',
                'url'   =>  url('/manajemen_presensi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Presensi anda gagal diubah']);
        }
    }
    public function delete(Presensi $presensi){
        if (!Gate::allows('delete-presensi')) {
            abort(403);
        }
        $delete = $presensi->delete();

        if ($delete) {
            $notification = array(
                'message' => 'Yeay, Presensi remunerasi berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('presensi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, Presensi remunerasi gagal dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
