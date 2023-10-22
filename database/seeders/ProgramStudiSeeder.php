<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
            DB::table('prodis')->insert(array([
                'id_prodi'           =>  'D13311',
                'kdjen'              =>  'D',
                'kdpst'              =>  13311,
                'nama_jenjang'       =>  'STr',
                'nama_prodi'         =>  'Gizi dan Dietetika',
                'nama_lengkap_prodi' =>  'STr - Gizi dan Dietetika',
                'kodefak'            =>  'GZ',
                'nmfak'              =>  'Gizi',
            ],
            [
                'id_prodi'           =>  'D13331',
                'kdjen'              =>  'D',
                'kdpst'              =>  13331,
                'nama_jenjang'       =>  'STr',
                'nama_prodi'         =>  'Promosi Kesehatan',
                'nama_lengkap_prodi' =>  'STr - Promosi Kesehatan',
                'kodefak'            =>  'KSH',
                'nmfak'              =>  'Promosi Kesehatan',
            ],
            [
                'id_prodi'           =>  'D14301',
                'kdjen'              =>  'D',
                'kdpst'              =>  14301,
                'nama_jenjang'       =>  'STr',
                'nama_prodi'         =>  'Keperawatan',
                'nama_lengkap_prodi' =>  'STr - Keperawatan',
                'kodefak'            =>  'PRW',
                'nmfak'              =>  'Keperawatan',
            ],
            [
                'id_prodi'           =>  'D15301',
                'kdjen'              =>  'D',
                'kdpst'              =>  15301,
                'nama_jenjang'       =>  'STr',
                'nama_prodi'         =>  'Kebidanan',
                'nama_lengkap_prodi' =>  'STr - Kebidanan',
                'kodefak'            =>  'BDN',
                'nmfak'              =>  'Kebidanan',
            ],
            [
                'id_prodi'           =>  'DM01',
                'kdjen'              =>  'D',
                'kdpst'              =>  'M01',
                'nama_jenjang'       =>  'STr',
                'nama_prodi'         =>  'Manajemen Informasi Kesehatan',
                'nama_lengkap_prodi' =>  'STr - Manajemen Informasi Kesehatan',
                'kodefak'            =>  'MIK',
                'nmfak'              =>  'Manajemen Informasi Kesehatan',
            ],
            [
                'id_prodi'           =>  'E13411',
                'kdjen'              =>  'E',
                'kdpst'              =>  13411,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Gizi',
                'nama_lengkap_prodi' =>  'DIII - Gizi',
                'kodefak'            =>  'GZ',
                'nmfak'              =>  'Gizi',
            ],
            [
                'id_prodi'           =>  'E13451',
                'kdjen'              =>  'E',
                'kdpst'              =>  13451,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Sanitasi',
                'nama_lengkap_prodi' =>  'DIII - Sanitasi',
                'kodefak'            =>  'SNT',
                'nmfak'              =>  'Kesehatan Lingkungan',
            ],
            [
                'id_prodi'           =>  'E13453',
                'kdjen'              =>  'E',
                'kdpst'              =>  13453,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Teknologi Laboratorium Medis',
                'nama_lengkap_prodi' =>  'DIII - Teknologi Laboratorium Medis',
                'kodefak'            =>  'MDS',
                'nmfak'              =>  'Analis Kesehatan',
            ],
            [
                'id_prodi'           =>  'E14401',
                'kdjen'              =>  'E',
                'kdpst'              =>  14401,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Keperawatan',
                'nama_lengkap_prodi' =>  'DIII - Keperawatan',
                'kodefak'            =>  'PRW',
                'nmfak'              =>  'Keperawatan',
            ],
            [
                'id_prodi'           =>  'E14471',
                'kdjen'              =>  'E',
                'kdpst'              =>  14471,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Keperawatan (Kampus Curup)',
                'nama_lengkap_prodi' =>  'DIII - Keperawatan (Kampus Curup)',
                'kodefak'            =>  'PRW',
                'nmfak'              =>  'Keperawatan',
            ],
            [
                'id_prodi'           =>  'E15401',
                'kdjen'              =>  'E',
                'kdpst'              =>  15401,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Kebidanan',
                'nama_lengkap_prodi' =>  'DIII - Kebidanan',
                'kodefak'            =>  'BDN',
                'nmfak'              =>  'Kebidanan',
            ],
            [
                'id_prodi'           =>  'E15471',
                'kdjen'              =>  'E',
                'kdpst'              =>  15471,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Kebidanan (Kampus Curup)',
                'nama_lengkap_prodi' =>  'DIII - Kebidanan (Kampus Curup)',
                'kodefak'            =>  'BDN',
                'nmfak'              =>  'Kebidanan',
            ],
            [
                'id_prodi'           =>  'E48401',
                'kdjen'              =>  'E',
                'kdpst'              =>  48401,
                'nama_jenjang'       =>  'DIII',
                'nama_prodi'         =>  'Farmasi',
                'nama_lengkap_prodi' =>  'DIII - Farmasi',
                'kodefak'            =>  'MDS',
                'nmfak'              =>  'Analis Kesehatan',
            ],
            [
                'id_prodi'           =>  'J14901',
                'kdjen'              =>  'J',
                'kdpst'              =>  14901,
                'nama_jenjang'       =>  'PROFESI',
                'nama_prodi'         =>  'Pendidikan Profesi Ners',
                'nama_lengkap_prodi' =>  'PROFESI - Pendidikan Profesi Ners',
                'kodefak'            =>  'PRW',
                'nmfak'              =>  'Keperawatan',
            ],
            [
                'id_prodi'           =>  'J15901',
                'kdjen'              =>  'J',
                'kdpst'              =>  15901,
                'nama_jenjang'       =>  'PROFESI',
                'nama_prodi'         =>  'Pendidikan Profesi Bidan',
                'nama_lengkap_prodi' =>  'PROFESI - Pendidikan Profesi Bidan',
                'kodefak'            =>  'BDN',
                'nmfak'              =>  'Kebidanan',
            ],
            ),
            );
    }
}
