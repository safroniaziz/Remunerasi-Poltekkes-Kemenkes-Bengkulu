<?php

namespace App\Http\Controllers;

use App\Models\JabatanDs;
use App\Models\JabatanDt;
use App\Models\JabatanFungsional;
use App\Models\PangkatGolongan;
use App\Models\Pegawai;
use App\Models\RiwayatJabatanDt;
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
            $dosens = Pegawai::with(['jabatanFungsionals'])
                                ->where('nama','LIKE','%'.$nama.'%')
                                ->orWhere('nip','LIKE','%'.$nama.'%')
                                ->orderBy('nama','asc')->paginate(10);

        }else {
            $dosens = Pegawai::with(['jabatanFungsionals'])->orderBy('nama','asc')->paginate(10);
        }
        return view('backend/dosens.index',[
            'dosens'    =>  $dosens,
            'nama'    =>  $nama,
        ]);
    }

    public function generateSiakad(){
        require_once app_path('Helpers/api/curl.api.php');
        require_once app_path('Helpers/api/config.php');

        $limit = 30; // Jumlah data yang ingin Anda ambil setiap kali load
        $offset = 0;
        $responses = array();

        $totalData = 0;

        // Mendapatkan total data dari API
        $parameter = array(
            'action' => 'dosen',
            'code' => '',
            'search' => '',
            'offset' => $offset,
            'offset' => 0, // Gunakan limit 1 untuk mendapatkan total data saja
            'limit' => 30, // Gunakan limit 1 untuk mendapatkan total data saja
        );

        $hashed_string = ApiEncController::encrypt(
            $parameter,
            $config['client_id'],
            $config['version'],
            $config['secret_key']
        );

        $data = array(
            'client_id' => $config['client_id'],
            'data' => $hashed_string,
        );

        $response = _curl_api($config['url'], json_encode($data));

        $response_array = json_decode($response, true);

        if (!empty($response_array) && isset($response_array['params']['total'])) {
            $totalData = $response_array['params']['total'];
        } else {
            return $responses; // Tidak ada data, langsung keluar
        }

        // Hitung total chunks yang dibutuhkan berdasarkan total data dan limit
        $totalChunks = ceil($totalData / $limit);

        for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
            $parameter['offset'] = $offset;
            $parameter['limit'] = $limit;

            $hashed_string = ApiEncController::encrypt(
                $parameter,
                $config['client_id'],
                $config['version'],
                $config['secret_key']
            );

            $data = array(
                'client_id' => $config['client_id'],
                'data' => $hashed_string,
            );

            $response = _curl_api($config['url'], json_encode($data));

            // Ubah respons menjadi array
            $response_array = json_decode($response, true);

            // Cek jika ada data yang diterima dari API
            if (!empty($response_array) && isset($response_array['data']) && count($response_array['data']) > 0) {
                foreach ($response_array['data'] as $pegawaiData) {
                    $homebase = strtolower($pegawaiData['homebase']);
                    $jurusan = null;

                    if (strpos($homebase, 'promosi') !== false) {
                        $jurusan = 'promosi_kesehatan';
                    } elseif (strpos($homebase, 'lingkungan') !== false) {
                        $jurusan = 'kesehatan_lingkungan';
                    } elseif (strpos($homebase, 'keperawatan') !== false) {
                        $jurusan = 'keperawatan';
                    } elseif (strpos($homebase, 'kebidanan') !== false) {
                        $jurusan = 'kebidanan';
                    } elseif (strpos($homebase, 'gizi') !== false) {
                        $jurusan = 'gizi';
                    } elseif (strpos($homebase, 'analis') !== false) {
                        $jurusan = 'analis_kesehatan';
                    } elseif (strpos($homebase, 'sanitasi') !== false) {
                        $jurusan = 'sanitasi';
                    } elseif (strpos($homebase, 'farmasi') !== false) {
                        $jurusan = 'farmasi';
                    } elseif (strpos($homebase, 'teknologi') !== false) {
                        $jurusan = 'teknologi_laboratorium_medis';
                    }
                    Pegawai::updateOrCreate(['nip' => $pegawaiData['nodos']], [
                        'nip'   =>  $pegawaiData['nodos'],
                        'nidn' => $pegawaiData['nidn'],
                        'nama' => $pegawaiData['nametitle'],
                        'slug' => Str::slug($pegawaiData['nametitle']),
                        'id_prodi_homebase'  =>  $pegawaiData['id_prodi_homebase'] ? $pegawaiData['id_prodi_homebase'] : null,
                        'jurusan' => $jurusan,
                    ]);
                }
            } else {
                // Tidak ada data lagi, keluar dari loop
                break;
            }

            // Update offset untuk mendapatkan data selanjutnya
            $offset += $limit;
        }

        $notification = array(
            'message' => 'Yeay, sinkronisasi data dosen dari siakad berhasil',
            'alert-type' => 'success'
        );
        return redirect()->route('dosen')->with($notification);
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
            'nip'                   =>  'required|unique:pegawais',
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
            'nip'                   =>  $request->nip,
            'slug'                  =>  Str::slug($request->nama),
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
            'email'                 =>  'email|',
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
            'nidn.required'                     => 'Jenis Kegiatan harus dipilih',
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
        if (!Gate::allows('read-jabatan-dt')) {
            abort(403);
        }
        $jabatans = JabatanDt::select('nama_jabatan_dt')->whereNotIn('nama_jabatan_dt',function($query) use ($pegawai) {
            $query->select('nama_jabatan_dt')->from('riwayat_jabatan_dts')->where('nip',$pegawai->nip);
         })->get();
        return view('backend.dosens.riwayat_jabatan_dt',[
            'pegawai'   =>  $pegawai,
            'jabatans'  =>  $jabatans,
        ]);
    }

    public function storeRiwayatJabatanDt(Request $request, Pegawai $pegawai){
        if (!Gate::allows('update-jabatan-fungsional')) {
            abort(403);
        }

        $rules = [
            'nama_jabatan_dt'       =>  'required',
            'tmt_jabatan_dt'        =>  'required|',
        ];
        $text = [
            'nama_jabatan_dt.required'      => 'Nama Jabatan DT harus diisi',
            'tmt_jabatan_dt.required'       => 'TMT Jabatan DT harus diisi',

        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = RiwayatJabatanDt::create([
            'nip'                       =>  $pegawai->nip,
            'nama_jabatan_dt'   =>  $request->nama_jabatan_dt,
            'slug'                      =>  Str::slug($request->nama_jabatan_dt),
            'tmt_jabatan_dt'   =>  $request->tmt_jabatan_dt,
            'is_active'   =>  0,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, riwayat jabatan DT berhasil ditambahkan',
                'url'   =>  route('dosen.riwayat_jabatan_dt',[$pegawai->slug]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, riwayat jabatan DT gagal disimpan']);
        }
    }

    public function setActiveRiwayatJabatanDt(Pegawai $pegawai, RiwayatJabatanDt $jabatanDt){
        RiwayatJabatanDt::where('nip',$pegawai->nip)->where('id','!=',$jabatanDt->id)->update([
            'is_active' =>  0,
        ]);
        $update = $jabatanDt->update([
            'is_active' =>  1,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data riwayat jabatan dt berhasil diaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_jabatan_dt',[$pegawai->slug])->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data riwayat jabatan dt gagal diaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function setNonActiveRiwayatJabatanDt(Pegawai $pegawai, RiwayatJabatanDt $jabatanDt){
        $update = $jabatanDt->update([
            'is_active' =>  0,
        ]);
        if ($update) {
            $notification = array(
                'message' => 'Yeay, data riwayat jabatan dt berhasil dinonaktifkan',
                'alert-type' => 'success'
            );
            return redirect()->route('dosen.riwayat_jabatan_dt',[$pegawai->slug])->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooopps, data riwayat jabatan dt gagal dinonaktifkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function deleteRiwayatJabatanDt(Pegawai $pegawai, JabatanFungsional $jabatanFungsional){
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
}
