<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Periode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;


class PeriodeController extends Controller
{
    public function index(){
        if (!Gate::allows('read-periode')) {
            abort(403);
        }
        $periodes = Periode::orderBy('created_at','desc')->get();

        return view('backend/periode_penilaians.index',[
            'periodes'    =>  $periodes,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-periode')) {
            abort(403);
        }
        $rules = [
            'nama_periode'              =>  'required',
            'semester'                  =>  'required|numeric',
            'tahun_ajaran'              =>  'required|numeric',
            'bulan_pembayaran'          =>  'required',
            'bulan'                     =>  'required',
        ];
        $text = [
            'nama_periode.required'             => 'Nama Periode Penilaian harus diisi',
            'semester.numeric'                  => 'Semester harus berupa angka',
            'semester.required'                 => 'Semester harus diisi',
            'tahun_ajaran.required'             => 'Tahun Ajaran harus diisi',
            'tahun_ajaran.numeric '             => 'Tahun ajaran harus berupa angka',
            'bulan_pembayaran.required'         => 'Bulan Pembayaran harus dipilih',
            'bulan.required'                    => 'Bulan harus diisi',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $bulan = $request->bulan_pembayaran;
        $tahun = $request->tahun_ajaran;
        $tanggal_awal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggal_terakhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();
        $tanggal_awal_formatted = $tanggal_awal->format('Y-m-d');
        $tanggal_terakhir_formatted = $tanggal_terakhir->format('Y-m-d');

        $simpan = Periode::create([
            'nama_periode'          =>  $request->nama_periode,
            'slug'                  =>  Str::slug($request->nama_periode),
            'semester'              =>  $request->semester,
            'tahun_ajaran'          =>  $request->tahun_ajaran,
            'bulan'                 =>  $bulan,
            'bulan_pembayaran'      =>  $tahun,
            'tanggal_awal'          =>  $tanggal_awal_formatted,
            'tanggal_akhir'         =>  $tanggal_terakhir_formatted,
            'is_active'             =>  0,
        ]);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($simpan)
        ->event('created')
        ->withProperties([
            'created_fields' => $simpan, // Contoh informasi tambahan
        ])
        ->log(auth()->user()->nama_user . ' has created a new Periode Penilaian.');
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, periode remunerasi berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_periode/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, periode remunerasi gagal ditambahkan']);
        }
    }

    public function edit(Periode $periode){
        if (!Gate::allows('edit-periode')) {
            abort(403);
        }
        return $periode;
    }

    public function update(Request $request){
        if (!Gate::allows('update-periode')) {
            abort(403);
        }
        $rules = [
            'nama_periode_edit'              =>  'required',
            'semester_edit'                  =>  'required|numeric',
            'tahun_ajaran_edit'              =>  'required|numeric',
            'bulan_pembayaran_edit'          =>  'required',
        ];
        $text = [
            'nama_periode_edit.required'             => 'Nama Periode Penilaian harus diisi',
            'semester_edit.numeric'                  => 'Semester harus berupa angka',
            'semester.required'                 => 'Semester harus diisi',
            'tahun_ajaran_edit.required'             => 'Tahun Ajaran harus diisi',
            'tahun_ajaran_edit.numeric '             => 'Tahun ajaran harus berupa angka',
            'bulan_pembayaran_edit.required'         => 'Bulan Pembayaran harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $dataOld=Periode::where('id',$request->periode_id_edit)->first();
        $oldData = $dataOld->toArray();

        $bulan = $request->bulan_pembayaran_edit;
        $tahun = $request->tahun_ajaran_edit;
        $tanggal_awal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggal_terakhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();
        $tanggal_awal_formatted = $tanggal_awal->format('Y-m-d');
        $tanggal_terakhir_formatted = $tanggal_terakhir->format('Y-m-d');
        $update = Periode::where('id',$request->periode_id_edit)->update([
            'nama_periode'          =>  $request->nama_periode_edit,
            'slug'                  =>  Str::slug($request->nama_periode_edit),
            'semester'              =>  $request->semester_edit,
            'tahun_ajaran'          =>  $tahun,
            'bulan'                 =>  $request->bulan_edit,
            'bulan_pembayaran'      =>  $bulan,
            'tanggal_awal'          =>  $tanggal_awal_formatted,
            'tanggal_akhir'         =>  $tanggal_terakhir_formatted,
        ]);

        $data=Periode::where('id',$request->periode_id_edit)->first();
        $newData = $data->toArray();

        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($data)
        ->event('updated')
        ->withProperties([
            'old_data' => $oldData, // Data lama
            'new_data' => $newData, // Data baru
        ])
        ->log(auth()->user()->nama_user . ' has updated the periode penelitian data.');
        if ($update) {
            return response()->json([
                'text'  =>  'Yeay,periode remunerasi berhasil diubah',
                'url'   =>  url('/manajemen_data_periode/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, periode remunerasi gagal diubah']);
        }
    }

    public function setNonActive(Periode $periode){

        $oldData = $periode->toArray();

        $update = $periode->update([
            'is_active' =>  0,
        ]);

        $newData = $periode->toArray();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($periode)
            ->event('deactivated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has deactivated the periode data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, periode remunerasi berhasil dinonaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('periode_penilaian')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, periode remunerasi gagal dinonaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }

    public function setActive(Periode $periode){
        Periode::where('id','!=',$periode->id)->update([
            'is_active' =>  0,
        ]);

        $oldData = $periode->toArray();
        $update = $periode->update([
            'is_active' =>  1,
        ]);
        $newData = $periode->toArray();

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($periode)
            ->event('activated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log(auth()->user()->nama_user . ' has activated the periode data.');
            if ($update) {
                $notification = array(
                    'message' => 'Yeay, periode remunerasi berhasil diaktifkan',
                    'alert-type' => 'success'
                );
                return redirect()->route('periode_penilaian')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, periode remunerasi gagal diaktifkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }

    public function delete(Periode $periode){
        if (!Gate::allows('delete-periode')) {
            abort(403);
        }

        $oldData = $periode->toArray();
        $delete = $periode->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($periode)
            ->event('deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log(auth()->user()->nama_user . ' has deleted the periode data.');
            if ($delete) {
                $notification = array(
                    'message' => 'Yeay, periode remunerasi berhasil dihapus',
                    'alert-type' => 'success'
                );
                return redirect()->route('periode_penilaian')->with($notification);
            }else {
                $notification = array(
                    'message' => 'Ooopps, periode remunerasi gagal dihapus',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
    }
}
