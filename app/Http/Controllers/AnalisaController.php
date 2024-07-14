<?php

namespace App\Http\Controllers;

use App\BayesAlgorithm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisaController extends Controller
{
    public function lihatAnalisa(Request $request) {
        $kode_siswa = $request->input('kodeSiswa');
        $data_siswa = NULL;
        $hasil_analisa = NULL;
        if (!empty($kode_siswa)) {
            $data_siswa = DB::table('siswa')
                ->where('kodeSiswa', $kode_siswa)
                ->first();

            if (!$data_siswa) {
                return redirect()
                    ->route('analisa.kesimpulan')
                    ->withErrors(['kodeSiswa' => 'Siswa dengan kode tersebut tidak dapat ditemukan']);
            }

        
            $data_kuisioner = DB::table('kuisioner')
                ->addSelect('kuisioner.idKuisioner', DB::raw('siswa.nama AS namaSiswa'), 'kuisioner.kuisioner')
                ->join('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa')
                ->where('siswa.idSiswa', $data_siswa->idSiswa)
                ->get();

            if (count($data_kuisioner) <= 0) {
                return redirect()
                    ->route('analisa.kesimpulan')
                    ->with(['error' => 'Siswa belum mengisi kuisioner']); 
            }
            foreach ($data_kuisioner as $index => $kuisioner) {
                $data_kuisioner[$index]->kuisioner = json_decode($kuisioner->kuisioner);
            }
            $bayes = new BayesAlgorithm($data_kuisioner);
            $hasil_analisa = $bayes->lihatHasilAkhir()[0];
    
            list($total_ya, $total_tidak) = $bayes->ambilProbabilitasLabel();
            $hasil_analisa->total_ya = $total_ya;
            $hasil_analisa->total_tidak = $total_tidak;
            $hasil_analisa->total_kesuluruhan = $total_ya + $total_tidak;
        }


        $view =  view('analisa')
            ->with('hasil_analisa', $hasil_analisa)
            ->with('data_siswa', $data_siswa);
        return $view;
    }
}
