<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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
        $dosens = $prodi->dosens;
        return view('backend.prodis.data_dosen',[
            'prodi' =>  $prodi,
            'dosens'    =>  $dosens,
        ]);
    }
}
