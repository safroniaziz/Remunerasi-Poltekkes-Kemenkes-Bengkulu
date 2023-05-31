<?php

namespace App\Http\Controllers;

use App\Models\JabatanDs;
use App\Models\JabatanDt;
use App\Models\JabatanFungsional;
use App\Models\PangkatGolongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $request){
        if (!Gate::allows('read-pegawai')) {
            abort(403);
        }
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $dosens = Pegawai::with(['jabatanFungsionals'])->where('nama','LIKE','%'.$nama.'%')
                                ->orderBy('created_at','desc')->paginate(10);

        }else {
            $dosens = Pegawai::with(['jabatanFungsionals'])->orderBy('created_at','desc')->paginate(10);
        }
        return view('backend/dosens.index',[
            'dosens'    =>  $dosens,
            'nama'    =>  $nama,
        ]);
    }

    public function create(){
        if (!Gate::allows('create-pegawai')) {
            abort(403);
        }
        $jabatanDts = JabatanDt::all();
        return view('backend/dosens.create',[
            'jabatanDts'   =>   $jabatanDts,
        ]);
    }

    public function store(Request $request){
        if (!Gate::allows('store-pegawai')) {
            abort(403);
        }
        $rules = [
            'nama'                  =>  'required',
            'nip'                   =>  'required|numeric|unique:pegawais',
            'nidn'                  =>  'required|numeric',
            'email'                 =>  'required|email|unique:pegawais',
            'jenis_kelamin'         =>  'required',
            'jurusan'               =>  'required',
            'nomor_rekening'        =>  'required|numeric',
            'npwp'                  =>  'required|numeric',
            'no_whatsapp'           =>  'required|numeric',
            'is_serdos'             =>  'required',
        ];
        $text = [
            'nama.required'                     => 'Nama Lengkap harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'nip.unique'                        => 'Nip sudah digunakan',
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',
            'nidn.numeric '                     => 'NIDN harus berupa angka',
            'email.required'                    => 'Email harus diisi',
            'email.email'                       => 'Email harus berupa email',
            'email.unique'                      => 'Email sudah digunakan',
            'jenis_kelamin.required'            => 'Jenis kelamin harus dipilih',
            'jurusan.required'                  => 'Jurusan harus diisi',
            'nomor_rekening.required'           => 'Nomor Rekening harus diisi',
            'nomor_rekening.numeric'            => 'Nomor Rekening harus berupa angka',
            'npwp.required'                     => 'NPWP harus diisi',
            'npwp.numeric'                      => 'NPWP harus berupa angka',
            'no_whatsapp.numeric'               => 'Nomor WhatsApp harus berupa angka ',
            'is_serdos.required'                => 'Status Serdos harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = Pegawai::create([
            'nama'                  =>  $request->nama,
            'slug'                  =>  Str::slug($request->nama),
            'nip'                   =>  $request->nip,
            'nidn'                  =>  $request->nidn,
            'email'                 =>  $request->email,
            'jenis_kelamin'         =>  $request->jenis_kelamin,
            'jurusan'               =>  $request->jurusan,
            'nomor_rekening'        =>  $request->nomor_rekening,
            'jabatan_dt_id'         =>  $request->jabatan_dt_id,
            'npwp'                  =>  $request->npwp,
            'no_whatsapp'           =>  $request->no_whatsapp,
            'is_serdos'             =>  $request->is_serdos == 'ya' ? 1 : 0,
            'no_sertifikat_serdos'  =>  $request->no_sertifikat_serdos,
            'is_active'             =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, dosen baru berhasil ditambahkan',
                'url'   =>  url('/manajemen_data_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, usulan anda gagal disimpan']);
        }
    }

    public function edit(Pegawai $pegawai){
        if (!Gate::allows('edit-pegawai')) {
            abort(403);
        }
        $jabatanDts = JabatanDt::all();
        return view('backend.dosens.edit',[
            'pegawai'   =>  $pegawai,
            'jabatanDts'   =>  $jabatanDts,
        ]);
    }

    public function update(Request $request, Pegawai $pegawai){
        if (!Gate::allows('update-pegawai')) {
            abort(403);
        }
        $rules = [
            'nama'                  =>  'required',
            'nip'                   =>  'required',
            'nidn'                  =>  'required|numeric',
            'email'                 =>  'required|email|',
            'jenis_kelamin'         =>  'required',
            'jurusan'               =>  'required',
            'nomor_rekening'        =>  'required|numeric',
            'npwp'                  =>  'required|numeric',
            'no_whatsapp'           =>  'required|numeric',
            'is_serdos'             =>  'required',
        ];
        $text = [
            'nama.required'                     => 'Nama Lengkap harus diisi',
            'nip.required'                      => 'Nip harus dipilih',
            'nip.numeric'                       => 'Nip harus berupa angka',
            'nip.unique'                        => 'Nip sudah digunakan',
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',
            'nidn.numeric '                     => 'NIDN harus berupa angka',
            'email.required'                    => 'Email harus diisi',
            'email.email'                       => 'Email harus berupa email',
            'email.unique'                      => 'Email sudah digunakan',
            'jenis_kelamin.required'            => 'Jenis kelamin harus dipilih',
            'jurusan.required'                  => 'Jurusan harus diisi',
            'nomor_rekening.required'           => 'Nomor Rekening harus diisi',
            'nomor_rekening.numeric'            => 'Nomor Rekening harus berupa angka',
            'npwp.required'                     => 'NPWP harus diisi',
            'npwp.numeric'                      => 'NPWP harus berupa angka',
            'no_whatsapp.numeric'               => 'Nomor WhatsApp harus berupa angka ',
            'is_serdos.required'                => 'Status Serdos harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $pegawai->update([
            'nama'                  =>  $request->nama,
            'slug'                  =>  Str::slug($request->nama),
            'nip'                   =>  $request->nip,
            'nidn'                  =>  $request->nidn,
            'email'                 =>  $request->email,
            'jenis_kelamin'         =>  $request->jenis_kelamin,
            'jurusan'               =>  $request->jurusan,
            'nomor_rekening'        =>  $request->nomor_rekening,
            'npwp'                  =>  $request->npwp,
            'no_whatsapp'           =>  $request->no_whatsapp,
            'is_serdos'             =>  $request->is_serdos == 'ya' ? 1 : 0,
            'no_sertifikat_serdos'  =>  $request->no_sertifikat_serdos,
            'is_active'             =>  1,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, dosen baru berhasil diubah',
                'url'   =>  url('/manajemen_data_dosen/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, usulan anda gagal diubah']);
        }
    }

    public function setNonActive(Pegawai $dosen){
        $update = $dosen->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data dosen berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data dosen gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setActive(Pegawai $dosen){
        $update = $dosen->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data dosen berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data dosen gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function riwayatJabatanFungsional(Pegawai $pegawai){
        if (!Gate::allows('read-jabatan-fungsional')) {
            abort(403);
        }
        $jabatans = JabatanDs::select('nama_jabatan_ds')->whereNotIn('nama_jabatan_ds',function($query) use ($pegawai) {
            $query->select('nama_jabatan_fungsional')->from('jabatan_fungsionals')->where('nip',$pegawai->nip);
         })->get();
        return view('backend.dosens.riwayat_jabatan_fungsional',[
            'pegawai'   =>  $pegawai,
            'jabatans'  =>  $jabatans,
        ]);
    }

    public function storeRiwayatJabatanFungsional(Request $request, Pegawai $pegawai){
        if (!Gate::allows('update-jabatan-fungsional')) {
            abort(403);
        }
        $rules = [
            'nama_jabatan_fungsional'       =>  'required',
            'tmt_jabatan_fungsional'        =>  'required|',
        ];
        $text = [
            'nama_jabatan_fungsional.required'      => 'Nama Jabatan Fungsional harus diisi',
            'tmt_jabatan_fungsional.required'       => 'TMT Jabatan Fungsional harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = JabatanFungsional::create([
            'nip'                       =>  $pegawai->nip,
            'nama_jabatan_fungsional'   =>  $request->nama_jabatan_fungsional,
            'slug'                      =>  Str::slug($request->nama_jabatan_fungsional),
            'tmt_jabatan_fungsional'   =>  $request->tmt_jabatan_fungsional,
            'is_active'   =>  0,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, riwayat jabatan fungsional berhasil ditambahkan',
                'url'   =>  route('dosen.riwayat_jabatan_fungsional',[$pegawai->slug]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, riwayat jabatan fungsional gagal disimpan']);
        }
    }

    public function setActiveRiwayatJabatanFungsional(Pegawai $pegawai, JabatanFungsional $jabatanFungsional){
        JabatanFungsional::where('nip',$pegawai->nip)->where('id','!=',$jabatanFungsional->id)->update([
            'is_active' =>  0,
        ]);
        $update = $jabatanFungsional->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data riwayat jabatan fungsional berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_jabatan_fungsional',[$pegawai->slug])->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data riwayat jabatan fungsional gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setNonActiveRiwayatJabatanFungsional(Pegawai $pegawai, JabatanFungsional $jabatanFungsional){
        $update = $jabatanFungsional->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data riwayat jabatan fungsional berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_jabatan_fungsional',[$pegawai->slug])->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data riwayat jabatan fungsional gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function deleteRiwayatJabatanFungsional(Pegawai $pegawai, JabatanFungsional $jabatanFungsional){
        if (!Gate::allows('delete-jabatan-fungsional')) {
            abort(403);
        }
        if ($jabatanFungsional->is_active == 1) {
            $notification = array(
                'message' => 'Ooopps, riwayat jabatan fungsional aktif tidak bisa dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }else {
            $jabatanFungsional->delete();
            $notification = array(
                'message' => 'Yeay, data riwayat jabatan fungsional berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_jabatan_fungsional',[$pegawai->slug])->with($notification);
        }
    }

    public function riwayatPangkatGolongan(Pegawai $pegawai){
        if (!Gate::allows('read-pangkat-golongan')) {
            abort(403);
        }
        return view('backend.dosens.riwayat_pangkat_golongan',[
            'pegawai'   =>  $pegawai,
        ]);
    }

    public function storeRiwayatPangkatGolongan(Request $request, Pegawai $pegawai){
        if (!Gate::allows('store-pangkat-golongan')) {
            abort(403);
        }
        $rules = [
            'nama_pangkat'                  =>  'required',
            'golongan'                      =>  'required',
            'tmt_pangkat_golongan'          =>  'required',
        ];
        $text = [
            'nama_pangkat.required'             => 'Nama Pangkat harus diisi',
            'golongan.required'                 => 'Golongan harus diisi',
            'tmt_pangkat_golongan.required'     => 'TMT Pangkat & Golongan harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->nama_pangkat == "IA") {
            $golongan = "Juru Muda";
        }elseif ($request->nama_pangkat == "IB") {
            $golongan = "Juru Muda Tingkat 1";
        }elseif ($request->nama_pangkat == "IC") {
            $golongan = "Juru";
        }elseif ($request->nama_pangkat == "ID") {
            $golongan = "Juru Tingkat 1";
        }elseif ($request->nama_pangkat == "IIA") {
            $golongan = "Pengatur Muda";
        }elseif ($request->nama_pangkat == "IIB") {
            $golongan = "Pengatur Muda Tingkat 1";
        }elseif ($request->nama_pangkat == "IIC") {
            $golongan = "Pengatur";
        }elseif ($request->nama_pangkat == "IID") {
            $golongan = "Pengatur Tingkat 1";
        }elseif ($request->nama_pangkat == "IIIA") {
            $golongan = "Penata Muda";
        }elseif ($request->nama_pangkat == "IIIB") {
            $golongan = "Penata Muda Tingkat 1";
        }elseif ($request->nama_pangkat == "IIIC") {
            $golongan = "Penata";
        }elseif ($request->nama_pangkat == "IIID") {
            $golongan = "Penata Tingkat 1";
        }elseif ($request->nama_pangkat == "IVA") {
            $golongan = "Pembina";
        }elseif ($request->nama_pangkat == "IVB") {
            $golongan = "Pembina Tingkat 1";
        }elseif ($request->nama_pangkat == "IVC") {
            $golongan = "Pembina Utama Muda";
        }elseif ($request->nama_pangkat == "IVD") {
            $golongan = "Pembina Utama Madya";
        }elseif ($request->nama_pangkat == "IVE") {
            $golongan = "Pembina Utama";
        }

        $simpan = PangkatGolongan::create([
            'nip'                       =>  $pegawai->nip,
            'nama_pangkat'              =>  $request->nama_pangkat,
            'golongan'                  =>  $golongan,
            'slug'                      =>  Str::slug($request->nama_pangkat),
            'tmt_pangkat_golongan'      =>  $request->tmt_pangkat_golongan,
            'is_active'   =>  0,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, riwayat pangkat & golongan berhasil ditambahkan',
                'url'   =>  route('dosen.riwayat_pangkat_golongan',[$pegawai->slug]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, riwayat pangkat & golongan gagal disimpan']);
        }
    }

    public function setActiveRiwayatPangkatGolongan(Pegawai $pegawai, PangkatGolongan $pangkatGolongan){
        PangkatGolongan::where('nip',$pegawai->nip)->where('id','!=',$pangkatGolongan->id)->update([
            'is_active' =>  0,
        ]);
        $update = $pangkatGolongan->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data riwayat pangkat & golongan berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_pangkat_golongan',[$pegawai->slug])->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data riwayat pangkat & golongan gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function deleteRiwayatPangkatGolongan(Pegawai $pegawai, PangkatGolongan $pangkatGolongan){
        if (!Gate::allows('delete-pangkat-golongan')) {
            abort(403);
        }
        if ($pangkatGolongan->is_active == 1) {
            $notification = array(
                'message' => 'Ooopps, riwayat pangkat & golongan aktif tidak bisa dihapus',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }else {
            $pangkatGolongan->delete();
            $notification = array(
                'message' => 'Yeay, data riwayat pangkat & golongan berhasil dihapus',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_pangkat_golongan',[$pegawai->slug])->with($notification);
        }
    }

    public function riwayatJabatanDt(Pegawai $pegawai){
        if (!Gate::allows('read-riwayat-jabatan-dt')) {
            abort(403);
        }
        return view('backend.dosens.riwayat_jabatan_dt',[
            'pegawai'   =>  $pegawai,
        ]);
    }
}
