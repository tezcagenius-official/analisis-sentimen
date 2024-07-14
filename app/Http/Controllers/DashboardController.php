<?php

namespace App\Http\Controllers;

use App\BayesAlgorithm;
use App\Constant\Runtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $data_kelas = DB::table('kelas')->get();
        $data_guru = DB::table('guru')->get();
        $data_siswa = DB::table('siswa')->get();

        $kesimpulan = new stdClass();
        $query = DB::table('kuisioner')
            ->addSelect('kuisioner.idKuisioner', DB::raw('siswa.nama AS namaSiswa'), DB::raw('kelas.namaKelas AS namaKelas'), 'kuisioner.kuisioner')
            ->join('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa')
            ->join('kelas', 'kelas.idKelas', '=', 'siswa.idKelas');

        $user = $request->session()->get('user');
        if ($user->role_type == Runtime::ROLE_GURU) {
            $query->where('kelas.waliKelas', $user->id);
        }
        $data_kuisioner = $query->get();
        foreach ($data_kuisioner as $index => $kuisioner) {
            $data_kuisioner[$index]->kuisioner = json_decode($kuisioner->kuisioner);
        }
        $bayes = new BayesAlgorithm($data_kuisioner); 

        $hasil = $bayes->lihatHasilAkhir();
        $total_tp = count(array_filter($hasil->toArray(), function ($item) {
            return $item->kategori == 'TP';
        }));
        $total_tn = count(array_filter($hasil->toArray(), function ($item) {
            return $item->kategori == 'TN';
        }));
        $total_fn = count(array_filter($hasil->toArray(), function ($item) {
            return $item->kategori == 'FN';
        }));
        $total_fp = count(array_filter($hasil->toArray(), function ($item) {
            return $item->kategori == 'FP';
        }));
        $kesimpulan->total_tp = $total_tp;
        $kesimpulan->total_tn = $total_tn;
        $kesimpulan->total_fn = $total_fn;
        $kesimpulan->total_fp = $total_fp;

        return view('dashboard')
            ->with('data_guru', $data_guru)
            ->with('data_kelas', $data_kelas)
            ->with('data_siswa', $data_siswa)
            ->with('data_kuisioner', $data_kuisioner)
            ->with('kesimpulan', $kesimpulan)
            ->with('user', $request->session()->get('user'));
    }
}
