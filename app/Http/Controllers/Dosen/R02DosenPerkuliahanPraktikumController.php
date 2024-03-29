<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Prodi;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\NilaiEwmp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\R02PerkuliahanPraktikum;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiEncController;
use Spatie\Activitylog\Traits\LogsActivity;


class R02DosenPerkuliahanPraktikumController extends Controller
{
    private $nilai_ewmp;
    private $periode;
    private $periodeAktif;
    public function __construct()
    {
        $this->periode = Periode::where('is_active',1)->first();
        $this->periodeAktif = $this->periode->tahun_ajaran.''.$this->periode->semester;
        $this->nilai_ewmp = NilaiEwmp::where('nama_tabel_rubrik','r02_perkuliahan_praktikums')->first();
    }

    public function index(){
        $dataProdis = Prodi::all();
        $pegawais = Pegawai::all();
         $r02perkuliahanpraktikum = R02PerkuliahanPraktikum::where('nip',$_SESSION['data']['kode'])
                                                    ->where('periode_id',$this->periode->id)
                                                    ->orderBy('created_at','desc')->get();

                return view('backend/dosen/rubriks/r_02_perkuliahan_praktikums.index',[
                    'pegawais'                =>  $pegawais,
                    'periode'                 =>  $this->periode,
                    'dataProdis'                 =>  $dataProdis,
                    'r02perkuliahanpraktikums'    =>  $r02perkuliahanpraktikum,
                ]);
        }

    public function store(Request $request){
        $rules = [
            'kode_kelas'            =>  'required',
            'nama_matkul'            =>  'required',
            'jumlah_sks'            =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_tatap_muka'     =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'           => 'Nama Mata Kuliah harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;
        $simpan = R02PerkuliahanPraktikum::create([
            'periode_id'        =>  $this->periode->id,
            // 'nip'               =>  $_SESSION['data']['kode'],
            'nip'=>$_SESSION['data']['kode'],	// optional by dosen
            'kode_kelas'       =>  $request->kode_kelas,
            'nama_matkul'       =>  $request->nama_matkul,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'id_prodi'  =>  $request->id_prodi,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,

        ]);

        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($simpan)
            ->event('dosen_created')
            ->withProperties([
                'created_fields' => $simpan, // Contoh informasi tambahan
            ])
            ->log($_SESSION['data']['nama'] . ' has created a new R2 Perkuliahan Praktikum.');

            if ($simpan) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Perkuliahan Praktikum baru berhasil ditambahkan',
                    'url'   =>  url('/dosen/r_02_perkuliahan_praktikum/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Perkuliahan Praktikum gagal disimpan']);
            }
        }
        else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function edit($r02perkuliahanpraktikum){
        $data = R02PerkuliahanPraktikum::where('id',$r02perkuliahanpraktikum)->first();
        return $data;
    }

    public function update(Request $request, R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $rules = [
            'kode_kelas'            =>  'required',
            'nama_matkul'           =>  'required',
            'jumlah_sks'            =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_tatap_muka'     =>  'required|regex:/^[0-9]+$/|min:0',
            'jumlah_mahasiswa'      =>  'required|regex:/^[0-9]+$/|min:0',
            'is_bkd'                =>  'required',
            'id_prodi'                =>  'required',
        ];
        $text = [
            'jumlah_sks.required'       => 'Jumlah SKS harus diisi',
            'jumlah_sks.numeric'        => 'jumlah SKS harus berupa angka',
            'jumlah_mahasiswa.required' => 'Jumlah Mahasiswa harus diisi',
            'jumlah_mahasiswa.numeric'  => 'Jumlah Mahasiswa harus berupa angka',
            'jumlah_tatap_muka.required'=> 'Jumlah Tatap Muka harus diisi',
            'jumlah_tatap_muka.numeric' => 'Jumlah Tatap Muka harus berupa angka',
            'is_bkd.required'           => 'Status rubrik harus dipilih',
            'kode_kelas.required'           => 'Kode Kelas harus diisi',
            'nama_matkul.required'           => 'Nama Mata Kuliah harus dipilih',
            'id_prodi.required'           => 'Prodi mengajar harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $point = (($request->jumlah_tatap_muka/16)*($request->jumlah_mahasiswa/40))* $this->nilai_ewmp->ewmp*$request->jumlah_sks;

        $data =  R02PerkuliahanPraktikum::where('id',$request->r02perkuliahanpraktikum_id_edit)->first();
        $oldData = $data->toArray();

        $update = $data->update([
            'periode_id'        =>  $this->periode->id,
            // 'nip'               =>  $_SESSION['data']['kode'],
            'nip'=>$_SESSION['data']['kode'],	// optional by dosen
            'kode_kelas'       =>  $request->kode_kelas,
            'nama_matkul'       =>  $request->nama_matkul,
            'jumlah_sks'        =>  $request->jumlah_sks,
            'jumlah_tatap_muka' =>  $request->jumlah_tatap_muka,
            'jumlah_mahasiswa'  =>  $request->jumlah_mahasiswa,
            'id_prodi'  =>  $request->id_prodi,
            'is_bkd'            =>  $request->is_bkd,
            'is_verified'       =>  0,
            'point'             =>  $point,
            'keterangan'        =>  $request->keterangan,
        ]);

        $newData = $data->toArray();

        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();
        if (!empty($dosen)) {
        activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_updated')
            ->withProperties([
                'old_data' => $oldData, // Data lama
                'new_data' => $newData, // Data baru
            ])
            ->log($_SESSION['data']['nama'] . ' has updated the R2 Perkuliahan Praktikum data.');

            if ($update) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Perkuliahan Praktikum berhasil diubah',
                    'url'   =>  url('/dosen/r_02_perkuliahan_praktikum/'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Perkuliahan Praktikum anda gagal diubah']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function delete($r02perkuliahanpraktikum){
        $data =  R02PerkuliahanPraktikum::where('id',$r02perkuliahanpraktikum)->first();
        $oldData = $data->toArray();
        $delete = R02PerkuliahanPraktikum::where('id',$r02perkuliahanpraktikum)->delete();

        $dosen = Pegawai::where('nip',$_SESSION['data']['kode'])->first();

        if (!empty($dosen)) {
            activity()
            ->causedBy($dosen)
            ->performedOn($data)
            ->event('dosen_deleted')
            ->withProperties([
                'old_data' => $oldData, // Data lama
            ])
            ->log($_SESSION['data']['nama'] . ' has deleted the R01 Perkuliahan Teori data.');

            if ($delete) {
                return response()->json([
                    'text'  =>  'Yeay, Rubrik Perkuliahan Praktikum berhasil dihapus',
                    'url'   =>  route('dosen.r_02_perkuliahan_praktikum'),
                ]);
            }else {
                return response()->json(['text' =>  'Oopps, Rubrik Perkuliahan Praktikum gagal dihapus']);
            }
        }else{
            $notification = array(
                'message' => 'Data anda tidak ada di siakad, hubungi admin siakad',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function verifikasi(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $r02perkuliahanpraktikum->update([
            'is_verified'   =>  1,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function tolak(R02PerkuliahanPraktikum $r02perkuliahanpraktikum){
        $r02perkuliahanpraktikum->update([
            'is_verified'   =>  0,
        ]);

        $notification = array(
            'message' => 'Berhasil, status verifikasi berhasil diubah',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function siakad(Request $request){
        require_once app_path('Helpers/api/curl.api.php');
        require_once app_path('Helpers/api/config.php');

        $kodeJenjang = substr($request->kodeProdi, 0, 1); // Mengambil karakter pertama
        $kodePst = substr($request->kodeProdi, 1); // Mengambil sisanya
        $parameter = array(
            'action'=>'kelasperkuliahan',
            'thsms'=>$this->periodeAktif,	// Tahun Akademik (5 digit angka)
            'kdjen'=>$kodeJenjang,		// Kode Jenjang
            'kdpst'=>$kodePst,		// Kode Prodi
            'kdkmk'=>'',
            'sks_mk'    =>  'praktikum',
            'nodos' =>  $_SESSION['data']['kode'],		// Search Kode MK (Optional) | can string or array (Optional)
            'search'=>'',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
            // 'offset'    =>  30,
            // 'id_kls'    =>"20222E13451II AKL.1.3.01",
            'limit'    =>  30,
            'offset'    =>  0,
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
        $nipDosen = $_SESSION['data']['kode'];
        $res = ' ';
        $no = 1;
        if (count($response_array['data'])>0) {
            foreach ($response_array['data'] as $value) {
                $checkData = R02PerkuliahanPraktikum::where('periode_id',$this->periode->id)
                                                ->where('nip',$nipDosen)
                                                ->where('kode_kelas',$value['id_kls'])
                                                ->first();
                if (!empty($checkData)) {
                    $statusDisabled = 'disabled';
                    $class = 'class="bg-success"';
                } else {
                    $statusDisabled = '';
                    $class = '';
                }

                $res .=
                '<tr ' . $class . '>
                    <td><input type="checkbox" name="id_kelas[]" value="' . $value['id_kls'] . '" ' . $statusDisabled . '></td>
                    <td>' . $no++ . '</td>
                    <td>' . $value['nama_mk'] . '</td>
                    <td>' . $value['jml_peserta'] . '</td>
                    <td>' . $value['kdpst'] . '</td>
                    <td>' . $value['kdjen'] . '</td>
                    <td>' . $value['semester'] . '</td>
                    <td>' . $value['sks_mk_info']['praktikum'] . '</td>
                </tr>';
            }
        }
        else{
            $res = '<tr><td colspan="8" class="text-danger text-center">Data Kosong</td></tr>';
        }
        $kodeProdi = substr($request->kodeProdi, 1);
        $kodeJenjang = substr($request->kodeProdi, 0, 1);

        $hasil = [
            'res'   =>  $res,
            'kodeProdi' =>  $kodeProdi,
            'kodeJenjang'   =>  $kodeJenjang,
        ];

        return $hasil;
    }

    public function siakadPost(Request $request){
        require_once app_path('Helpers/api/curl.api.php');
        require_once app_path('Helpers/api/config.php');
        $perkuliahan = array();
        foreach ($request->id_kelas as $id_kelas) {
            $parameter = array(
                'action'=>'kelasperkuliahan',
                'thsms'=>$this->periodeAktif,	// Tahun Akademik (5 digit angka)
                'kdjen'=>$request->kodeJenjang,		// Kode Jenjang
                'kdpst'=>$request->kodeProdi,		// Kode Prodi
                'kdkmk'=>'',
                'sks_mk'    =>  'praktikum',
                'search'=>'',		// Search Kode Mata Kuliah / Nama Mata Kuliah Sesuai (Optional)
                // 'offset'    =>  30,
                'id_kls'    => $id_kelas,
                'limit'    =>  30,
                'offset'    =>  0,
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

            $parameter_presensi = array(
                'action'=>'absensi.get',
                'thsms'=>$this->periodeAktif,
                'kdjen'=>$request->kodeJenjang,
                'kdpst'=>$request->kodeProdi,
                'id_kls'=>$id_kelas,
                'nodos'=>$_SESSION['data']['kode'],	// optional by dosen
                'date1'=>$this->periode->tanggal_awal,	// optional rentang tanggal mulai Y-m-d
                'date2'=>$this->periode->tanggal_akhir,	// optional rentang tanggal akhir Y-m-d
                'offset'=>'',		// mulai data dari 0 / 10 (Optional)
                'limit'=>'',		// batas (Optional)
            );

            $hashed_string_presensi = ApiEncController::encrypt(
                $parameter_presensi,
                $config['client_id'],
                $config['version'],
                $config['secret_key']
            );

            $dataPresensi = array(
                'client_id' => $config['client_id'],
                'data' => $hashed_string_presensi,
            );

            $responsePresensi = _curl_api($config['url'], json_encode($dataPresensi));
            $response_array_presensi = json_decode($responsePresensi, true);
            if (count($response_array_presensi['data'])>0) {
                $presensi = $response_array_presensi['data'][0]['detail'];
            }else{
                $presensi = [];
            }
            $result = [
                'kelas' =>  $response_array['data'][0],
                'presensi' =>  $presensi,
            ];

            $jumlahSks = $result['kelas']['sks_mk_info']['praktikum'] != null ? $result['kelas']['sks_mk_info']['praktikum'] : 0;
            $point = ((count($result['presensi'])/16)*($result['kelas']['jml_peserta']/40))* $this->nilai_ewmp->ewmp*$jumlahSks;

            $perkuliahan[]  =   array(
                'periode_id'    =>  $this->periode->id,
                'nip'           =>  $_SESSION['data']['kode'],
                'nama_matkul'   =>  $result['kelas']['nama_mk'],
                'kode_kelas'   =>  $result['kelas']['id_kls'],
                'jumlah_sks'   =>  $jumlahSks,
                'jumlah_mahasiswa'   =>  $result['kelas']['jml_peserta'],
                // 'jumlah_tatap_muka' =>  $presensi == null ? null : count($result['presensi']),
                // 'jumlah_tatap_muka'   =>  null,
                'jumlah_tatap_muka' =>  count($result['presensi']),

                'id_prodi'      =>  $request->kodeJenjang.$request->kodeProdi,
                'is_bkd'        => 0,
                'is_verified'   => 0,
                'sumber_data'   =>  'siakad',
                'created_at'    =>  now(), // Menggunakan fungsi now() untuk waktu saat ini
                'updated_at'    =>  now(),
                'point'         =>  $point,
                'keterangan'    =>  $request->keterangan,
            );
        }

        R02PerkuliahanPraktikum::insert($perkuliahan);

        return response()->json([
            'text'  =>  'Yeay, Data Pengajaran Praktikum Siakad Berhasil Disimpan',
            'url'   =>  url('/dosen/r_02_perkuliahan_praktikum/'),
        ]);
    }
}
