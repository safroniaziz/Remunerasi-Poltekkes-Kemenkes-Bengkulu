<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;


class ProdiController extends Controller
{
    public function index(){
        if (!Gate::allows('view-prodi')) {
            abort(403);
        }
        $prodis = Prodi::withCount('dosens')->get();

        return view('backend/prodis.index',[
            'prodis'    =>  $prodis,
        ]);
    }

    public function generate(){
        if (!Gate::allows('generate-prodi')) {
            abort(403);
        }
        require_once app_path('Helpers/api/curl.api.php');
        require_once app_path('Helpers/api/config.php');

        $parameter = array(
            'action'=>'prodi',
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
        $prodis = array();
        if (isset($response_array['data']) && is_array($response_array['data'])) {
            foreach ($response_array['data'] as $prodi) {
                $prodis[$prodi['id_prodi']] = array(
                    'id_prodi'              => $prodi['id_prodi'],
                    'kdjen'                 =>  $prodi['kdjen'],
                    'kdpst'                 =>  $prodi['kdpst'],
                    'nama_jenjang'          =>  $prodi['nama_jenjang'],
                    'nama_prodi'            =>  $prodi['nama_prodi'],
                    'nama_lengkap_prodi'    =>  $prodi['nmprodi'],
                    'kodefak'               =>  $prodi['kodefak'],
                    'nmfak'               =>  $prodi['nmfak'],
                );
            }
            foreach ($prodis as $id_prodi => $data) {
                DB::table('prodis')
                    ->updateOrInsert(
                        ['id_prodi' => $id_prodi],
                        $data
                    );
            }
            activity()
            ->causedBy(auth()->user()->id)
            ->event('created')
            ->log(auth()->user()->nama_user . ' has Click the Generate Program Studi value page.');
            $notification = array(
                'message' => 'Yeayy, Sinkronisasi Program Studi Dari Siakad Berhasil',
                'alert-type' => 'success'
            );
            return redirect()->route('prodi')->with($notification);
        }else {
            $notification = array(
                'message' => 'Ooooppss, Sinkronisasi gagal, coba beberapa saat lagi',
                'alert-type' => 'error'
            );
            return redirect()->route('prodi')->with($notification);
        }
    }

    public function dataDosen(Prodi $prodi){
        if (!Gate::allows('view-dosen-prodi')) {
            abort(403);
        }
        $prodi = Prodi::with(['dosens'])->where('id_prodi',$prodi->id_prodi)->first();

        return view('backend.prodis.data_dosen',[
            'prodi' =>  $prodi,
        ]);
    }

    public function dataVerifikator(Prodi $prodi){
        if (!Gate::allows('view-verifikator-prodi')) {
            abort(403);
        }
        $verifikators = Pegawai::all();

        return view('backend.prodis.data_verifikator',[
            'prodi' =>  $prodi,
            'verifikators' =>  $verifikators,
        ]);
    }

    public function verifikatorStore(Prodi $prodi, Request $request){
        if (!Gate::allows('store-verifikator-prodi')) {
            abort(403);
        }

        $rules = [
            'verifikator_nip'      =>  'required',
            'penanggung_jawab_nip'      =>  'required',
        ];

        $text = [
            'verifikator_nip.required'           => 'Verifikator harus dipilih',
            'penanggung_jawab_nip.required'           => 'Penanggung Jawab harus dipilih',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $update = $prodi->update([
            'verifikator_nip'    =>  $request->verifikator_nip,
            'penanggung_jawab_nip'    =>  $request->penanggung_jawab_nip,
        ]);

        $verifikator = Pegawai::where('nip',$request->verifikator_nip)->first();
        $isCreated = User::where('pegawai_nip',$request->verifikator_nip)->first();
        if (empty($isCreated)) {
            $userVerifikator = User::create([
                'nama_user' =>  $verifikator->nama,
                'pegawai_nip'       =>  $verifikator->nip,
                'email'       =>  $verifikator->email,
                'password'  =>  Hash::make('Remunerasi@2023'),
                'is_active' =>  1,
            ]);
            $userVerifikator->assignRole('verifikator');
        }

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, Verifikator berhasil ditambahkan',
                'url'   =>  route('prodi.verifikator',[$prodi->id_prodi]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, Permission gagal ditambahkan']);
        }
    }
}
