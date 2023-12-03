<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawais = array(
            array(
                "pegawai_nip" => " 4015028401",
                "nama_user" => "Anditha Ratnadhiyani, Ns.M.Kep., Sp.Kep.MB.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0008115707",
                "nama_user" => "Entang Inoriah S",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0018096006",
                "nama_user" => "Dra Ngudining, M.Hum.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0029078301",
                "nama_user" => "I Nyoman Candra",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0201106901",
                "nama_user" => "Hartian Pansori",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0206126201",
                "nama_user" => "Jelita Zakaria",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0228057201",
                "nama_user" => "Meriwati, M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "0309068906",
                "nama_user" => "Indah Fitri Andini, S.ST., M.Keb.",
                "email" => "tes@mail.com",
            ),
            array(
                "pegawai_nip" => "1029048804",
                "nama_user" => "Andra Saferi Wijaya, S.Kep., M.Kep., NERS.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1376055705880001",
                "nama_user" => "Fitri Rahayu",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1708055405850001",
                "nama_user" => "Ester Meylina Sipahutar",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "177102251075000",
                "nama_user" => "Elfahmi Lubis",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1771044804870001",
                "nama_user" => "Ade Sissca Villia",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1771046904950005",
                "nama_user" => "Ijazati Alfitroh, M.Farm.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1771064108950002",
                "nama_user" => "Dina Anggraini",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1771070107800001",
                "nama_user" => "Jaksen Sadri",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1771086212900002",
                "nama_user" => "Ade Zayu Cempaka Sari",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "1802050101860008",
                "nama_user" => "Gani Asa Dudin",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "2029127601",
                "nama_user" => "Adisel",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "3216206202940002",
                "nama_user" => "Ade Febryanti",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "3403127401",
                "nama_user" => "Ervan",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "3412047201",
                "nama_user" => "Kurniyati, SST., M.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4001036802",
                "nama_user" => "Halimah, M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4001038101",
                "nama_user" => "Idramsyah, M.Kep., Sp.KMB.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4001047201",
                "nama_user" => "Halimatussadiah, S.KM., M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4001096901",
                "nama_user" => "Linda, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4002027501",
                "nama_user" => "Asmawati, S.Kp., M.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4003016302",
                "nama_user" => "Dr. Darwis, S.Kp., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4003127801",
                "nama_user" => "Elvi Destariyani, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4004017101",
                "nama_user" => "Chandra Buana, M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4004057801",
                "nama_user" => "Farida Esmianti, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4004087301",
                "nama_user" => "Miratul Haya, M.GZ.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4004117701",
                "nama_user" => "Efrizon Hariadi, M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4005037301",
                "nama_user" => "Dino Sumaryono, S.KM., M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4005127301",
                "nama_user" => "Desri Suryani, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4006027501",
                "nama_user" => "Emy Yuliantini, M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4006027802",
                "nama_user" => "Eva Susanti, S.S.T., M.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4006107601",
                "nama_user" => "Haidina Ali, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4006127402",
                "nama_user" => "Husni, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4007078702",
                "nama_user" => "Erni Buston, M.Kes., S.ST., A.MD.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4007106801",
                "nama_user" => "Agung Riyadi, Ns.S.Kep., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4007107901",
                "nama_user" => "Hesty Widyasih",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009017401",
                "nama_user" => "Epti Yorita, M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009026001",
                "nama_user" => "Jubaidi, S.KM., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009056501",
                "nama_user" => "Eliana, S.KM., M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009097102",
                "nama_user" => "Agus Widada, S.KM., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009107402",
                "nama_user" => "Lisma Ningsih, S.KM., A.MD.Kep., M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4009107702",
                "nama_user" => "Dr. Reny Suryanti, SH.M.Sc.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4010066401",
                "nama_user" => "Almaini, S.Kp., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4010128001",
                "nama_user" => "Diah Eka Nugraheni, M.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4011037701",
                "nama_user" => "Misniarti, M.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4011037702",
                "nama_user" => "Defi Ermayendri, M.I.L., S.T.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4011107701",
                "nama_user" => "Lela Hartini, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4012027501",
                "nama_user" => "Jumiyati, M.GZ.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4013078301",
                "nama_user" => "Kheli Fitria Annuril, S.Kep., M.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4013118401",
                "nama_user" => "Apt. Heti Rais Khasanah, M.Sc.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4013125601",
                "nama_user" => "Kosma Heryati, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4014118301",
                "nama_user" => "Krisyanella, M.Farm.APT.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4015058201",
                "nama_user" => "Hendri Heriyanto, S.Kep., M.Kep., NERS.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4015067701",
                "nama_user" => "Jon Farizal, S.ST., M.Si.MED.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4016048502",
                "nama_user" => "Aplina Kartika Sari, S.ST., M.KL.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4016058101",
                "nama_user" => "Kusdalinah, M.GZ.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4017017603",
                "nama_user" => "Leli Mulyati, M.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4017028101",
                "nama_user" => "Arie Krisnasary, M.BIOMED.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4017087601",
                "nama_user" => "Dr. Demsa Simbolon, S.KM., M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4017127101",
                "nama_user" => "Derison Marsinova Bakara, S.Kp., M.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4017128001",
                "nama_user" => "Desi Widiyanti, M.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4018038501",
                "nama_user" => "Andriana Marwanto, SKM., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4018048301",
                "nama_user" => "Afriyana Siregar, S.GZ., M.BIOMED.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4018087401",
                "nama_user" => "Kamsiah, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4018128502",
                "nama_user" => "Ns. Mercy Nafratilova, M.Kep., Sp.Kep.AN.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4019088001",
                "nama_user" => "Lusi Andriani, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4019088601",
                "nama_user" => "Dira Irnameria, S.Si., M.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4019108201",
                "nama_user" => "Anang Wahyudi, S.GZ., M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4020108002",
                "nama_user" => "Fatimah Khoirini, S.S.T., M.Kes., A.MD.Kep.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021036602",
                "nama_user" => "Elly Wahyuni, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021037201",
                "nama_user" => "Mardiani, S.Kep., M.M., NERS.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021048201",
                "nama_user" => "Avrilya Iqoranny, S.Farm., APT.M.PHARM.SCI.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021068602",
                "nama_user" => "Lissa Ervina, S.Kep., M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021077801",
                "nama_user" => "Ismiati, M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4021127801",
                "nama_user" => "Deri Kermelita, S.KM., M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4022036302",
                "nama_user" => "Ahmad Rizal, SKM., M.M.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4022087401",
                "nama_user" => "Heru Laksono, M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4022116203",
                "nama_user" => "Dr. drg. Daisy Novira, M.ARS.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4023068801",
                "nama_user" => "Dwie Yunita Baska, A.MD., S.ST., M.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4025056601",
                "nama_user" => "Mariati, S.KM., M.P.H.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4026097101",
                "nama_user" => "Dahrizal, S.Kp., M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4026097301",
                "nama_user" => "Dr. Betty Yosephin Simanjuntak, SKM., M.KM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4027027501",
                "nama_user" => "Leni Marlina, S.Kep., NERS., M.Sc.A.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4027038601",
                "nama_user" => "Arie Ikhwan Saputra, S.S.T., M.T.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4029087701",
                "nama_user" => "Mely Gustina, S.KM., M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "4030048402",
                "nama_user" => "Afrina Mizawati, SST., M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "8921300020",
                "nama_user" => "Else Sri Rahayu, SST., M.Tr.Keb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "9940012187",
                "nama_user" => "Delta Baharyati, M.S.Farm.APT.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D002",
                "nama_user" => "Ayu Pravita Sari, M.GIZI.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D003",
                "nama_user" => "Lydia Febrina, SSTMTrKeb.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D007",
                "nama_user" => "Edy Purnomo, M.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D008",
                "nama_user" => "dr. Evi Fitriany, M.BIOMED.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D009",
                "nama_user" => "Guntur Baruara, SST., M.BIOMED.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D014",
                "nama_user" => "Ade Sissca Villia",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D016",
                "nama_user" => "Dwi Wulandari",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "D102",
                "nama_user" => "Likusman, SKM., M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.026",
                "nama_user" => "Desi Maryani, SH.MH.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.028",
                "nama_user" => "Mazrul Aziz",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.029",
                "nama_user" => "Jelita Zakaria",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.033",
                "nama_user" => "Ilham Syukri",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.037",
                "nama_user" => "Milda Lestari",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.041",
                "nama_user" => "Drs. Zainal Arifin, SH.MH.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.047",
                "nama_user" => "Dr. Lukman Asha, M.Pd.I.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.062",
                "nama_user" => "dr. Aminullah Djuang, SPOG.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.063",
                "nama_user" => "Lisa Pitrianti, SST.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.067",
                "nama_user" => "Agus Riyan Oktori, M.Pd.I.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.068",
                "nama_user" => "dr. Juen Vardona, Sp.OG.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.070",
                "nama_user" => "Dr. Noermanzah, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.076",
                "nama_user" => "dr. Kartika, Sp.PAT.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.078",
                "nama_user" => "Conny Tonggo Masdelima, SH.MH.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.086",
                "nama_user" => "Dr. Andriyanto, SH.M.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.087",
                "nama_user" => "Khariza Krisnandya, M.H.Kes.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.088",
                "nama_user" => "Dr. Zulkarnain, M.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.090",
                "nama_user" => "Dr.Malia Agustuna.Z, M.SCSP.P.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.091",
                "nama_user" => "Lucky Novalia, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.092",
                "nama_user" => "Eko Sunarso, M.Pd.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L.094",
                "nama_user" => "Diana Zomrotus Sa`adah, M.Psi.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L007",
                "nama_user" => "Iztin Syarifah Ma`ni, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L008",
                "nama_user" => "Melinda Putri, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L009",
                "nama_user" => "Andi Aprianto, M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L010",
                "nama_user" => "Andang Wijanarko, M.Kom.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L013",
                "nama_user" => "Deni Astuti, SKM., MKM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L014",
                "nama_user" => "Alfina Hidayanti, SKM., MKM.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L018",
                "nama_user" => "Ahmad Azmi Nasution",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L020",
                "nama_user" => "Corien, S.Psi.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L025",
                "nama_user" => "Antory Rayyen Adyan",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L030",
                "nama_user" => "Aplan Sarkawi",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L034",
                "nama_user" => "Delfan Eko Putra",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L038",
                "nama_user" => "Anton Royan",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L040",
                "nama_user" => "Aswin Fallahudin, S.Si., M.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L042",
                "nama_user" => "Ermi Novianti, S.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L043",
                "nama_user" => "Busra Febriyarni, M.Ag.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L044",
                "nama_user" => "Dr. Murnianto, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L049",
                "nama_user" => "Andik Purwanto, M.Ph.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L050",
                "nama_user" => "Apt. Delia Komala Sari, M.Farm.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L052",
                "nama_user" => "dr. Besly, Sp.PK.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L053",
                "nama_user" => "Mira Susilawati Nike, S.Farm.APT.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L054",
                "nama_user" => "dr. Dio Rahmat Biade, Sp.A.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L065",
                "nama_user" => "Agus Mailiza, S.Si., M.Si.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L069",
                "nama_user" => "David Aprizona Putra, SH.MH.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L075",
                "nama_user" => "Lukman, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L077",
                "nama_user" => "Dr.Muhammad Istan, M.Pd.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "L089",
                "nama_user" => "dr. Muhammad Galih Supandji, SP.",
                "email" => NULL,
            ),
            array(
                "pegawai_nip" => "LATIHAN 1",
                "nama_user" => "H. Ahmad Farhan, S.Si.M.Si.",
                "email" => NULL,
            ),
        );
        foreach ($pegawais as $pegawai) {
            $pegawai['password'] = bcrypt('password');
            $pegawai = User::create($pegawai);
            $pegawaiRole = Role::firstOrCreate(['name' => 'pegawai']);
            $pegawai->roles()->attach($pegawaiRole);
        }
    }
}
