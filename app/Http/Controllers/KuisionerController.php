<?php

namespace App\Http\Controllers;

use App\BayesAlgorithm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

class KuisionerController extends Controller
{
    public function lihatKuisioner(Request $request) {
        $query = DB::table('kuisioner')
            ->addSelect('kuisioner.idKuisioner', DB::raw('siswa.nama AS namaSiswa'), 'kuisioner.kuisioner')
            ->join('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa');
        
        if ($request->has('query')) {
            $query->where('siswa.nama', 'LIKE', '%'.$request->get('query'). '%');
        }

        $data_kuisioner = $query->get();

        foreach ($data_kuisioner as $index => $data) {
            $kuisioner = json_decode($data->kuisioner);
            $data_kuisioner[$index]->kuisioner = $kuisioner;
        }

        $bayes = new BayesAlgorithm($data_kuisioner);
        return view('kuisioner.index')  
            ->with('data_kuisioner', $bayes->lihatHasilAkhir())
            ->with('user', $request->session()->get('user'));
    }

    public function formTambahKuisioner(Request $request) {
        $path = base_path('pertanyaan.json');
        $data_pertanyaan = file_get_contents($path);
        $data_siswa = DB::table('siswa')
            ->addSelect('siswa.idSiswa', 'siswa.nama', 'kelas.namaKelas')
            ->join('kelas', 'siswa.idKelas', '=', 'kelas.idKelas')
            ->get();
        return view('kuisioner.form')
            ->with('data_pertanyaan',json_decode($data_pertanyaan))
            ->with('page_title', 'Kuisioner Baru')
            ->with('data', NULL)
            ->with('target_route', 'tambah.kuisioner')
            ->with('data_siswa', $data_siswa)
            ->with('user', $request->session()->get('user'));
    }

    public function tambahKuisioner(Request $request) {
        $path = base_path('pertanyaan.json');
        $data_pertanyaan = json_decode(file_get_contents($path));

        $user_input_field_rules = [
            'idSiswa' => 'required|unique:kuisioner,idSiswa',
            'pertanyaan' => 'required|array'
        ];

        foreach ($data_pertanyaan as $pertanyaan) {
            $field_name = sprintf('pertanyaan.%d', $pertanyaan->id);
            $user_input_field_rules[$field_name] = 'required';
        }

        $user_input = $request->only('idSiswa', 'pertanyaan');
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($data_pertanyaan as $index => $pertanyaan) {
            $data_pertanyaan[$index]->value = $user_input['pertanyaan'][$pertanyaan->id];
        }

        $kuisioner_record = [
            'idSiswa' => $user_input['idSiswa'],
            'kuisioner' => json_encode($data_pertanyaan)
        ];
        DB::table('kuisioner')
            ->insert($kuisioner_record);
        return redirect()
            ->route('daftar.kuisioner')
            ->with(['success' => 'Data kuisioner berhasil ditambahkan']);
    }

    public function formUbahKuisioner(Request $request, $idKuisioner) {
        $data = DB::table('kuisioner')
            ->where('idKuisioner', $idKuisioner)
            ->first();

        if (!$data) {
            return back()
                ->with(['error' => 'Data kuisioner tidak ditemukan']);
        }

        $data_pertanyaan = json_decode($data->kuisioner);
        $data_siswa = DB::table('siswa')
            ->addSelect('siswa.idSiswa', 'siswa.nama', 'kelas.namaKelas')
            ->join('kelas', 'siswa.idKelas', '=', 'kelas.idKelas')
            ->get();
        return view('kuisioner.form')
            ->with('data_pertanyaan', $data_pertanyaan)
            ->with('page_title', 'Mengubah Kuisioner')
            ->with('data', $data)
            ->with('user', $request->session()->get('user'))
            ->with('target_route', 'ubah.kuisioner')
            ->with('data_siswa', $data_siswa); 
    }

    public function ubahKuisioner(Request $request) {
        $idKuisioner = $request->input('idKuisioner');
        $path = base_path('pertanyaan.json');
        $data_pertanyaan = json_decode(file_get_contents($path));

        $user_input_field_rules = [
            'idSiswa' => 'required|unique:kuisioner,idSiswa,'.$idKuisioner.',idKuisioner',
            'pertanyaan' => 'required|array'
        ];

        foreach ($data_pertanyaan as $pertanyaan) {
            $field_name = sprintf('pertanyaan.%d', $pertanyaan->id);
            $user_input_field_rules[$field_name] = 'required';
        }

        $user_input = $request->only('idSiswa', 'pertanyaan');
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            dd($validator->errors());
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($data_pertanyaan as $index => $pertanyaan) {
            $data_pertanyaan[$index]->value = $user_input['pertanyaan'][$pertanyaan->id];
        }

        $kuisioner_record = [
            'kuisioner' => json_encode($data_pertanyaan),
            'idSiswa' => $user_input['idSiswa']
        ];
        DB::table('kuisioner')
            ->where('idKuisioner', $idKuisioner)
            ->update($kuisioner_record);

        return redirect()
            ->route('daftar.kuisioner')
            ->with(['success' => 'Data kuisioner berhasil dirubah']);
    }

    public function hapusKuisioner(Request $request, $idKuisioner) {
        $kuisioner_record = DB::table('kuisioner')
            ->where('idKuisioner', $idKuisioner)
            ->first();
    
        if (!$kuisioner_record) {
            return back()
                ->with(['error' => 'Data kuisioner tidak']);
        }

        DB::table('kuisioner')
            ->where('idKuisioner', $idKuisioner)
            ->delete();

        return redirect()
            ->route('daftar.kuisioner')
            ->with(['success' => 'Data kuisioner berhasil hapus']); 
    }

    public function analisa(Request $request) {
        $data_kuisioner = DB::table('kuisioner')
            ->addSelect('kuisioner.idKuisioner', 'kuisioner.kuisioner')
            ->addSelect('siswa.nama')
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa')
            ->get();

        foreach ($data_kuisioner as $index => $kuisioner) {
            $data_kuisioner[$index]->kuisioner = json_decode($kuisioner->kuisioner);
        }
        $bayes = new BayesAlgorithm($data_kuisioner);
        $hasil_analisa = $bayes->lihatHasilAkhir();
    }

    public function lihatHasilAnalisa(Request $request, $idKuisioner) {
        $data_kuisioner = DB::table('kuisioner')
            ->addSelect('kuisioner.idKuisioner', DB::raw('siswa.nama AS namaSiswa'), 'kuisioner.kuisioner')
            ->join('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa')
            ->where('idKuisioner', $idKuisioner)
            ->get();
        foreach ($data_kuisioner as $index => $kuisioner) {
            $data_kuisioner[$index]->kuisioner = json_decode($kuisioner->kuisioner);
        }
        $bayes = new BayesAlgorithm($data_kuisioner);
        $hasil_analisa = $bayes->lihatHasilAkhir()[0];

        list($total_ya, $total_tidak) = $bayes->ambilProbabilitasLabel();
        $hasil_analisa->total_ya = $total_ya;
        $hasil_analisa->total_tidak = $total_tidak;
        $hasil_analisa->total_kesuluruhan = $total_ya + $total_tidak;
        return view('kuisioner.analisa')
            ->with('user', $request->session()->get('user'))
            ->with('hasil_analisa', $hasil_analisa);
    }

    public function analisaKesimpulan(Request $request) {
        $kesimpulan = new stdClass();
        $data_kuisioner = DB::table('kuisioner')
            ->addSelect('kuisioner.idKuisioner', DB::raw('siswa.nama AS namaSiswa'), 'kuisioner.kuisioner')
            ->join('siswa', 'siswa.idSiswa', '=', 'kuisioner.idSiswa')
            ->get();
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
        return view('kuisioner.kesimpulan')
            ->with('user', $request->session()->get('user'))
            ->with('kesimpulan', $kesimpulan);
    }
    
}
