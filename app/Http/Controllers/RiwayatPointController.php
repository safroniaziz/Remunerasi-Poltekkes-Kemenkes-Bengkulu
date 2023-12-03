<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RiwayatPoint;
use App\Models\Periode;
use App\Models\Rubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Traits\LogsActivity;

class RiwayatPointController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-riwayat-point')) {
            abort(403);
        }
        $nip = $request->query('nip');
        if (!empty($nip)) {
            $riwayatpoints = RiwayatPoint::where('nip','LIKE','%'.$nip.'%')
                                ->paginate(10);

        }else {
            $riwayatpoints = RiwayatPoint::paginate(10);
        }

        return view('backend/riwayat_points.index',[
            'riwayatpoints'         =>  $riwayatpoints,
            'nip'        =>  $nip,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-riwayat-point')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        $periodes = Periode::all();

        return view('backend/riwayat_points.create',compact('dosens','periodes'));
    }

    public function store(Request $request){
        if (!Gate::allows('store-riwayat-point')) {
            abort(403);
        }
        $rules = [
            'rubrik_id'       =>  'required',
            'periode_id'      =>  'required',
            'nip'             =>  'required',
            'point'           =>  'required',
        ];
        $text = [
            'rubrik_id.required'    => 'rubrik harus diisi',
            'periode_id.required'   => 'periode harus dipilih',
            'nip.numeric'           => 'Nip harus berupa angka',
            'point.required'        => 'point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = RiwayatPoint::create([
            'rubrik_id'  =>  $request->rubrik_id,
            'periode_id' =>  $request->periode_id,
            'nip'        =>  $request->nip,
            'point'      =>  $request->point,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Riwayat Point.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Point baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_riwayat_point/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Point gagal disimpan']);
        }
    }
    public function edit(RiwayatPoint $riwayatpoint){
        if (!Gate::allows('edit-riwayat-point')) {
            abort(403);
        }
        $dosens = Pegawai::all();
        $periodes = Periode::all();
        return view('backend.riwayat_points.edit',compact('dosens','periodes'),[
            'pegawai'   =>  $riwayatpoint,
        ]);
    }

    public function update(Request $request, RiwayatPoint $riwayatpoint){
        if (!Gate::allows('update-riwayat-point')) {
            abort(403);
        }
        $rules = [
            'rubrik_id'       =>  'required',
            'periode_id'      =>  'required',
            'nip'             =>  'required',
            'point'           =>  'required',
        ];
        $text = [
            'rubrik_id.required'    => 'rubrik harus diisi',
            'periode_id.required'   => 'periode harus dipilih',
            'nip.numeric'           => 'Nip harus berupa angka',
            'point.required'        => 'point harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $data = RiwayatPoint::where('id',$request->nip_edit)->first();
        $oldData = $data->toArray();
        $update = $data->update([
            'rubrik_id'  =>  $request->rubrik_id,
            'periode_id' =>  $request->periode_id,
            'nip'        =>  $request->nip,
            'point'      =>  $request->point,
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
        ->log(auth()->user()->nama_user . ' has updated the Riwayat Point  data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Riwayat Point berhasil diubah',
                'url'   =>  url('/manajemen_riwayat_point/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Riwayat Point anda gagal diubah']);
        }
    }
    public function delete(RiwayatPoint $riwayatpoint){
        if (!Gate::allows('delete-riwayat-point')) {
            abort(403);
        }

            $oldData = $riwayatpoint->toArray();
            $delete = $riwayatpoint->delete();

            activity()
                ->causedBy(auth()->user()->id)
                ->performedOn($riwayatpoint)
                ->event('deleted')
                ->withProperties([
                    'old_data' => $oldData, // Data lama
                ])
                ->log(auth()->user()->nama_user . ' has deleted the Riwayat Point data.');
                if ($delete) {
                    $notification = array(
                        'message' => 'Yeay, Riwayat Point remunerasi berhasil dihapus',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('pegawai')->with($notification);
                }else {
                    $notification = array(
                        'message' => 'Ooopps, Riwayat Point remunerasi gagal dihapus',
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
            }
        }
    }
